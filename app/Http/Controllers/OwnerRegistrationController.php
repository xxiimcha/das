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
        // Validate the input data
        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email|max:255',
            'owner_phone' => 'required|string|max:15',
            'latitude' => 'required|numeric',  // Ensure latitude is a valid number
            'longitude' => 'required|numeric', // Ensure longitude is a valid number
            'formatted_address' => 'required|string|max:500',
            'dorm_name' => 'required|string|max:255',
            'price_range' => 'required|string|max:50',
            'dorm_capacity' => 'required|integer|min:1',
            'dorm_description' => 'required|string',
            'amenities' => 'array|required',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'permits.*' => 'nullable|file|max:5120',
        ]);
    
        try {
            DB::beginTransaction();
    
            // Generate a secure random password
            $plaintextPassword = 'password123'; // Default password
            $hashedPassword = Hash::make($plaintextPassword);
    
            // Create the user (Dorm Owner)
            $user = User::create([
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => $hashedPassword,
                'role' => 'owner',
                'status' => 'pending',
            ]);
    
            Log::info('New dorm owner registered', ['user_id' => $user->id]);
    
            // Store location as "latitude,longitude"
            $location = $validated['latitude'] . ',' . $validated['longitude'];
    
            // Create the dormitory
            $dormitory = Dormitory::create([
                'user_id' => $user->id,
                'name' => $validated['dorm_name'],
                'location' => $location,  // Store combined lat,long
                'formatted_address' => $validated['formatted_address'],
                'price_range' => $validated['price_range'],
                'capacity' => $validated['dorm_capacity'],
                'description' => $validated['dorm_description'],
                'status' => 'pending',
            ]);
    
            Log::info('Dormitory created', ['dormitory_id' => $dormitory->id]);
    
            // Store amenities
            foreach ($validated['amenities'] as $index => $amenity) {
                Amenity::create([
                    'dormitory_id' => $dormitory->id,
                    'name' => $amenity,
                    'icon' => $request->input("amenity_icons.$index", null),
                ]);
            }
    
            Log::info('Amenities added', ['dormitory_id' => $dormitory->id]);
    
            // Store dormitory images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/dorm_images');
                    DormitoryImage::create([
                        'dormitory_id' => $dormitory->id,
                        'image_path' => $path,
                    ]);
                }
            }
    
            // Store permits/documents
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
    
            // Send Email Notification with Login Credentials
            Mail::to($validated['owner_email'])->send(new OwnerRegistrationMail([
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => $plaintextPassword, // Send the plain password
            ]));
    
            Log::info('Registration email sent', ['email' => $validated['owner_email']]);
    
            return response()->json([
                'success' => true,
                'message' => 'Registration successful! A confirmation email has been sent.',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Owner Registration Error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }    
}