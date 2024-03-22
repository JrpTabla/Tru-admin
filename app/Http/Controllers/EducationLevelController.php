<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationLevel;
use Illuminate\Support\Carbon; // Import Carbon


class EducationLevelController extends Controller
{

    public function page($id)
    {

         // Find the education level by ID
        $hashedID = numhash($id);
        $educationLevel = EducationLevel::findOrFail($hashedID);


        return response()->json($educationLevel);

       
    }

    public function index() {
        $educationLevel = EducationLevel::where('delete_flg', 0)->get(); // Fetch blocked users

        $hashedEducationLevel = $educationLevel->map(function ($educationLevel) {
            $educationLevel->id = numhash($educationLevel->id);
            return $educationLevel;
        });

        return response()->json($hashedEducationLevel);
    }

    public function store(Request $request) {
        // Check if the name_level already exists and delete_flg is 0
        $existingLevel = EducationLevel::where('name_level', $request->name_level)
            ->where('delete_flg', 0)
            ->exists();
        
        if ($existingLevel) {
            // Return 1 if name_level already exists
            echo 1;
            return;
        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name_level' => 'required|string|max:255',
            // Add other validation rules here if needed
        ]);

        // Create a new EducationLevel instance
        $educationLevel = new EducationLevel();
        $educationLevel->name_level = $validatedData['name_level'];

        // Set the current date and time for created_date and updated_date
        $now = Carbon::now();
        $educationLevel->created_date = $now;
        $educationLevel->updated_date = $now;

        // Set other attributes here if needed
        
        // Save the EducationLevel instance
        $educationLevel->save();

        // Return a success message or perform any other action
        return 0;
    }

    public function update(Request $request, $id) {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationLevel = EducationLevel::findOrFail($hashedID);

        // Check if the name_level already exists and delete_flg is 0 for other records except the current one being updated
        $existingLevel = EducationLevel::where('name_level', $request->name_level)
            ->where('delete_flg', 0)
            ->where('id', '!=', $hashedID) // Exclude the current education level being updated
            ->exists();
        
        if ($existingLevel) {
            // Return 1 if name_level already exists
            echo 1;
            return;
        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name_level' => 'required|string|max:255',
            // Add other validation rules here if needed
        ]);

        // Update the education level's name
        $educationLevel->name_level = $validatedData['name_level'];
        $educationLevel->save();

        // Return a success message or perform any other action
        return 0;
    }   

    public function delete($id) {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationLevel = EducationLevel::findOrFail($hashedID);

        // Update delete_flg to mark as deleted (soft delete)
        $educationLevel->delete_flg = 1;
        $educationLevel->save();

        // Return a success message or perform any other action
        return 0;
    }

}



