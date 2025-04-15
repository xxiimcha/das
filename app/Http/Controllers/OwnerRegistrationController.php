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
        $validated = $request->validate([
            'dorm_id' => 'required|exists:dormitories,id',
            'token' => 'required|string',
            'dorm_name' => 'required|string|max:255',
            'price_range' => 'required|string|max:50',
            'dorm_capacity' => 'required|integer|min:1',
            'dorm_description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'formatted_address' => 'required|string|max:500',
            'amenities' => 'array|required',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'permits.*' => 'nullable|file|max:5120',
        ]);

        $dorm = Dormitory::findOrFail($validated['dorm_id']);

        // Check if token matches
        if ($dorm->invitation_token !== $validated['token']) {
            Log::warning("Token mismatch for dorm ID {$dorm->id}. Expected: {$dorm->invitation_token}, Received: {$validated['token']}");
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }

        try {
            DB::beginTransaction();

            // Update dormitory
            $dorm->update([
                'name' => $validated['dorm_name'],
                'location' => $validated['latitude'] . ',' . $validated['longitude'],
                'formatted_address' => $validated['formatted_address'],
                'price_range' => $validated['price_range'],
                'capacity' => $validated['dorm_capacity'],
                'description' => $validated['dorm_description'],
                'status' => 'pending',
                'invitation_token' => null
            ]);
            Log::info("Dormitory #{$dorm->id} updated by owner: {$dorm->owner->email}");

            // Delete old data
            $dorm->amenities()->delete();
            $dorm->images()->delete();
            $dorm->documents()->delete();
            Log::info("Old amenities, images, and documents cleared for dormitory #{$dorm->id}");

            // Insert new amenities
            foreach ($validated['amenities'] as $index => $amenity) {
                $dorm->amenities()->create([
                    'name' => $amenity,
                    'icon' => $request->input("amenity_icons.$index", null),
                ]);
            }
            Log::info("Inserted " . count($validated['amenities']) . " amenities for dormitory #{$dorm->id}");

            // Insert new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/dorm_images');
                    $dorm->images()->create(['image_path' => $path]);
                }
                Log::info("Dormitory #{$dorm->id} images uploaded.");
            }

            // Insert new permits
            if ($request->hasFile('permits')) {
                foreach ($request->file('permits') as $permit) {
                    $path = $permit->store('public/dorm_documents');
                    $dorm->documents()->create(['file_path' => $path]);
                }
                Log::info("Dormitory #{$dorm->id} permits/documents uploaded.");
            }

            DB::commit();
            Log::info("Dormitory #{$dorm->id} registration completed. Token invalidated.");

            return redirect('/')->with('success', 'Registration completed! Awaiting approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Owner form update failed for dormitory #{$dorm->id}: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
