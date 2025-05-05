<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Dormitory;
use App\Models\Amenity;
use App\Models\DormitoryImage;
use App\Models\DormitoryDocument;
use Illuminate\Support\Facades\Mail;
use App\Mail\OwnerRegistrationMail;

class OwnerRegistrationController extends Controller
{
    public function show(Request $request)
    {
        $token = $request->query('token');
        $dormId = $request->query('dorm_id');

        if (!$token || !$dormId) {
            abort(403, 'Invalid access link.');
        }

        // Get dorm with matching ID and token
        $dorm = Dormitory::with('owner')
            ->where('id', $dormId)
            ->where('invitation_token', $token)
            ->first();

        if (!$dorm) {
            abort(403, 'This link has expired or is invalid.');
        }

        return view('dorm_owner_registration', [
            'dorm' => $dorm,
            'owner' => $dorm->owner
        ]);
    }

    public function store(Request $request)
    {
        Log::info("Raw Request Payload", $request->all());
        Log::info("[Dorm Owner Registration] Received submission", [
            'request_dorm_id' => $request->input('dorm_id'),
            'request_token' => $request->input('token'),
            'submitted_fields' => $request->except(['images', 'permits']),
        ]);

        $validated = $request->validate([
            'dorm_id' => 'required|exists:dormitories,id',
            'token' => 'required|string',
            'price_range' => 'required|string|max:50',
            'dorm_capacity' => 'required|integer|min:1',
            'dorm_description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'formatted_address' => 'required|string|max:500',
            'amenities' => 'required|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'permits.*' => 'nullable|file|max:5120',
        ]);

        $dorm = Dormitory::findOrFail($validated['dorm_id']);

        if ($dorm->invitation_token !== $validated['token']) {
            Log::warning("[Dorm Owner Registration] Token mismatch", [
                'dorm_id' => $dorm->id,
                'expected_token' => $dorm->invitation_token,
                'submitted_token' => $validated['token']
            ]);
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }

        try {
            DB::beginTransaction();

            $coordinates = "{$validated['latitude']},{$validated['longitude']}";

            Log::info("[Dorm Owner Registration] Updating dormitory fields", [
                'dorm_id' => $dorm->id,
                'location   ' => $coordinates,
                'formatted_address' => $validated['formatted_address'],
                'price_range' => $validated['price_range'],
                'capacity' => $validated['dorm_capacity'],
                'description' => $validated['dorm_description'],
            ]);

            $dorm->update([
                'location' => $coordinates,
                'formatted_address' => $validated['formatted_address'],
                'price_range' => $validated['price_range'],
                'capacity' => $validated['dorm_capacity'],
                'description' => $validated['dorm_description'],
                'status' => 'pending',
                'invitation_token' => null
            ]);

            // Clear old related data
            $dorm->amenities()->delete();
            $dorm->images()->delete();
            $dorm->documents()->delete();

            Log::info("[Dorm Owner Registration] Cleared previous amenities, images, and documents", [
                'dorm_id' => $dorm->id
            ]);

            // Insert amenities
            $amenityLogs = [];
            foreach ($validated['amenities'] as $index => $amenity) {
                $icon = $request->input("amenity_icons.$index", null);
                if ($amenity) {
                    $dorm->amenities()->create([
                        'name' => $amenity,
                        'icon' => $icon,
                    ]);
                    $amenityLogs[] = ['name' => $amenity, 'icon' => $icon];
                }
            }

            Log::info("[Dorm Owner Registration] Inserted amenities", [
                'dorm_id' => $dorm->id,
                'amenities' => $amenityLogs
            ]);

            // Upload images
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('public/dorm_images');
                        $dorm->images()->create(['image_path' => $path]);
                        $imagePaths[] = $path;
                    }
                }
                Log::info("[Dorm Owner Registration] Uploaded images", [
                    'dorm_id' => $dorm->id,
                    'image_paths' => $imagePaths
                ]);
            }

            // Upload permits
            if ($request->hasFile('permits')) {
                $permitPaths = [];
                foreach ($request->file('permits') as $permit) {
                    if ($permit->isValid()) {
                        $path = $permit->store('public/dorm_documents');
                        $dorm->documents()->create(['file_path' => $path]);
                        $permitPaths[] = $path;
                    }
                }
                Log::info("[Dorm Owner Registration] Uploaded permits/documents", [
                    'dorm_id' => $dorm->id,
                    'permit_paths' => $permitPaths
                ]);
            }

            DB::commit();
            Log::info("[Dorm Owner Registration] Registration successful", [
                'dorm_id' => $dorm->id,
                'status' => 'pending'
            ]);

            return redirect('/')->with('success', 'Registration completed! Awaiting approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("[Dorm Owner Registration] Registration failed", [
                'dorm_id' => $dorm->id ?? 'N/A',
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_payload' => $request->all()
            ]);
        
            // Return proper JSON for JS
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
        
    }
}
