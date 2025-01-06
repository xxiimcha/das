<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dormitory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OwnerController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_phone' => 'required|string|max:15',
            'owner_address' => 'required|string|max:255',
            'dorm_name' => 'required|string|max:255|unique:dormitories,name',
            'dorm_location' => 'required|string|max:255',
            'price_range' => 'required|string|max:255',
            'dorm_capacity' => 'required|integer|min:1',
            'dorm_description' => 'required|string',
            'amenities' => 'nullable|array',
            'amenity_icons' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'permits.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        try {
            Log::info('Validated Data:', $validatedData);

            // Create the owner
            $owner = User::create([
                'name' => $validatedData['owner_name'],
                'email' => $validatedData['owner_email'],
                'phone' => $validatedData['owner_phone'],
                'address' => $validatedData['owner_address'],
                'password' => Hash::make('defaultpassword123'),
            ]);

            Log::info('Owner created successfully: ', $owner->toArray());

            // Handle image uploads
            $uploadedImages = $this->handleFileUploads($request->file('images') ?? [], 'public/dormitory_images', $validatedData['dorm_name']);

            // Handle permit uploads
            $uploadedPermits = $this->handleFileUploads($request->file('permits') ?? [], 'public/permits', $validatedData['dorm_name'], 'permit-');

            // Combine amenities and their icons
            $amenitiesWithIcons = $this->combineAmenitiesAndIcons($validatedData['amenities'] ?? [], $validatedData['amenity_icons'] ?? []);

            // Create the dormitory
            $dormitory = Dormitory::create([
                'owner_id' => $owner->id,
                'name' => $validatedData['dorm_name'],
                'location' => $validatedData['dorm_location'],
                'price_range' => $validatedData['price_range'],
                'capacity' => $validatedData['dorm_capacity'],
                'description' => $validatedData['dorm_description'],
                'amenities' => json_encode($amenitiesWithIcons),
                'images' => json_encode($uploadedImages),
                'permits' => json_encode($uploadedPermits),
                'status' => 'pending',
            ]);

            Log::info('Dormitory created successfully: ', $dormitory->toArray());

            return redirect()->back()->with('success', 'Dormitory registered successfully! Your application is pending for approval.');
        } catch (\Exception $e) {
            Log::error('Error during dormitory registration:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Something went wrong. Please try again later.']);
        }
    }

    private function handleFileUploads(array $files, string $directory, string $dormName, string $prefix = '')
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $filename = $prefix . Str::slug($dormName) . '-' . uniqid() . '.' . $extension;

            // Use the specified directory (ensure it exists)
            $path = $file->storeAs($directory, $filename, 'public');
            $uploadedFiles[] = $path;
        }

        return $uploadedFiles;
    }

    private function combineAmenitiesAndIcons(array $amenities, array $icons)
    {
        $result = [];
        foreach ($amenities as $index => $amenity) {
            $result[] = [
                'amenity' => $amenity,
                'icon' => $icons[$index] ?? null,
            ];
        }
        return $result;
    }
}
