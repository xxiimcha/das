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
use App\Mail\DormAcceptedMail;

class OwnerRegistrationController extends Controller
{
    public function show(Request $request)
    {
        $token = $request->query('token');
        $dormId = $request->query('dorm_id');

        if (!$token || !$dormId) {
            abort(403, 'Invalid access link.');
        }

        $dorm = Dormitory::with('owner')
            ->where('id', $dormId)
            ->first();

        // If the token has already been used (null), redirect to Thank You page
        if ($dorm && $dorm->invitation_token === null) {
            return redirect()->route('thank.you');
        }

        // If token does not match or dorm doesn't exist
        if (!$dorm || $dorm->invitation_token !== $token) {
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

        $dorm = Dormitory::with('owner')->findOrFail($validated['dorm_id']);

        if ($dorm->invitation_token !== $validated['token']) {
            Log::warning("[Dorm Owner Registration] Token mismatch", [
                'dorm_id' => $dorm->id,
                'expected_token' => $dorm->invitation_token,
                'submitted_token' => $validated['token']
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired token.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $coordinates = "{$validated['latitude']},{$validated['longitude']}";

            $dorm->update([
                'location' => $coordinates,
                'formatted_address' => $validated['formatted_address'],
                'price_range' => $validated['price_range'],
                'capacity' => $validated['dorm_capacity'],
                'description' => $validated['dorm_description'],
                'status' => 'accepted',
                'invitation_token' => null
            ]);

            $dorm->amenities()->delete();
            $dorm->images()->delete();
            $dorm->documents()->delete();

            foreach ($validated['amenities'] as $index => $amenity) {
                $icon = $request->input("amenity_icons.$index", null);
                if ($amenity) {
                    $dorm->amenities()->create([
                        'name' => $amenity,
                        'icon' => $icon,
                    ]);
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('public/dorm_images');
                        $dorm->images()->create(['image_path' => $path]);
                    }
                }
            }

            if ($request->hasFile('permits')) {
                foreach ($request->file('permits') as $permit) {
                    if ($permit->isValid()) {
                        $path = $permit->store('public/dorm_documents');
                        $dorm->documents()->create(['file_path' => $path]);
                    }
                }
            }

            DB::commit();

            // ✅ Send confirmation email
            Mail::to($dorm->owner->email)->send(new DormAcceptedMail($dorm));

            return response()->json([
                'status' => 'success',
                'message' => 'Registration completed!',
                'redirect' => route('thank.you')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("[Dorm Owner Registration] Registration failed", [
                'dorm_id' => $dorm->id ?? 'N/A',
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_payload' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
