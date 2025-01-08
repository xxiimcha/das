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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email|max:255',
            'owner_phone' => 'required|string|max:15',
            'owner_address' => 'required|string|max:255',
            'dorm_name' => 'required|string|max:255',
            'dorm_location' => 'required|string|max:255',
            'price_range' => 'required|string|max:50',
            'dorm_capacity' => 'required|integer|min:1',
            'dorm_description' => 'required|string',
            'amenities' => 'array|required',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'permits.*' => 'nullable|file|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $password = 'password123'; // Or generate a random password
            $user = User::create([
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => Hash::make($password),
                'role' => 'owner',
            ]);

            $dormitory = Dormitory::create([
                'user_id' => $user->id,
                'name' => $validated['dorm_name'],
                'location' => $validated['dorm_location'],
                'price_range' => $validated['price_range'],
                'capacity' => $validated['dorm_capacity'],
                'description' => $validated['dorm_description'],
            ]);

            foreach ($validated['amenities'] as $index => $amenity) {
                Amenity::create([
                    'dormitory_id' => $dormitory->id,
                    'name' => $amenity,
                    'icon' => $request->input("amenity_icons.$index", null),
                ]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/dorm_images');
                    DormitoryImage::create([
                        'dormitory_id' => $dormitory->id,
                        'image_path' => $path,
                    ]);
                }
            }

            if ($request->hasFile('permits')) {
                foreach ($request->file('permits') as $permit) {
                    $path = $permit->store('public/dorm_documents');
                    DormitoryDocument::create([
                        'dormitory_id' => $dormitory->id,
                        'file_path' => $path,
                    ]);
                }
            }

            DB::commit();

            // Send Email
            $details = [
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => $password,
            ];

            Mail::to($validated['owner_email'])->send(new OwnerRegistrationMail($details));

            return response()->json(['success' => true, 'message' => 'Registration successful!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Owner Registration Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
}
