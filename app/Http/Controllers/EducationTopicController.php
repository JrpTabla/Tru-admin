<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationTopic;
use Illuminate\Support\Carbon; // Import Carbon


class EducationTopicController extends Controller
{
    public function page($id)
    {

         // Find the education level by ID
        $hashedID = numhash($id);
        $educationTopic = EducationTopic::findOrFail($hashedID);


        return response()->json($educationTopic);

       
    }

    public function index()
    {
        $educationTopics = EducationTopic::where('delete_flg', 0)->get();

        $hashedEducationTopics = $educationTopics->map(function ($educationTopic) {
            $educationTopic->id = numhash($educationTopic->id);
            return $educationTopic;
        });

        return response()->json($hashedEducationTopics);
    }
    
    public function store(Request $request)
    {
        // Check if the name_level already exists and delete_flg is 0
        $existingTopic = EducationTopic::where('name_topic', $request->name_topic)
            ->where('delete_flg', 0)
            ->exists();
        
        if ($existingTopic) {
            // Return 1 if name_level already exists
            echo 1;
            return;
        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name_topic' => 'required|string|max:255',
            // Add other validation rules here if needed
        ]);

        // Create a new EducationLevel instance
        $educationTopic = new EducationTopic();
        $educationTopic->name_topic = $validatedData['name_topic'];

        // Set the current date and time for created_date and updated_date
        $now = Carbon::now();
        $educationTopic->created_date = $now;
        $educationTopic->updated_date = $now;

        // Set other attributes here if needed
        
        // Save the EducationLevel instance
        $educationTopic->save();

        // Return a success message or perform any other action
        return 0;
    }

    public function update(Request $request, $id) {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationTopic = EducationTopic::findOrFail($hashedID);

        // Check if the name_level already exists and delete_flg is 0 for other records except the current one being updated
        $existingLevel = EducationTopic::where('name_topic', $request->name_topic)
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
            'name_topic' => 'required|string|max:255',
            // Add other validation rules here if needed
        ]);

        // Update the education level's name
        $educationTopic->name_topic = $validatedData['name_topic'];
        $educationTopic->save();

        // Return a success message or perform any other action
        return 0;
    }   

    public function delete($id) {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationTopic = EducationTopic::findOrFail($hashedID);

        // Update delete_flg to mark as deleted (soft delete)
        $educationTopic->delete_flg = 1;
        $educationTopic->save();

        // Return a success message or perform any other action
        return 0;
    }
}



