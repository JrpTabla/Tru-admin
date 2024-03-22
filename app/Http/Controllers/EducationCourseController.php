<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationCourse;
use App\Models\EducationLevel;
use App\Models\EducationTopic;
use Illuminate\Support\Carbon; // Import Carbon


class EducationCourseController extends Controller
{

    public function page($id)
    {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationCourse = EducationCourse::findOrFail($hashedID);

        return response()->json($educationCourse);

       
    }

    public function index($topic_id, $difficulty_id)
    {
        $hashed_difficulty_id = numhash($difficulty_id);
        $hashed_topic_id = numhash($topic_id);

        $educationCourses = EducationCourse::where('delete_flg', 0)
                                            ->where('education_level_id', $hashed_difficulty_id)
                                            ->where('education_topic_id', $hashed_topic_id)
                                            ->get();

        $hashedEducationCourses = $educationCourses->map(function ($educationCourse) use ($hashed_difficulty_id) {
            $educationCourse->id = numhash($educationCourse->id);

            // Retrieve the corresponding EducationLevel and EducationTopic records
            $educationCourse->level_name = EducationLevel::find($educationCourse->education_level_id)->name_level;
            $educationCourse->topic_name = EducationTopic::find($educationCourse->education_topic_id)->name_topic;

            // Format education_level_id and education_topic_id using numhash() function
            $educationCourse->education_level_id = numhash($educationCourse->education_level_id);
            $educationCourse->education_topic_id = numhash($educationCourse->education_topic_id);

            // Validate if education_level_id matches hashed_difficulty_id
            $educationCourse->matched_difficulty = ($educationCourse->education_level_id == $hashed_difficulty_id);

            return $educationCourse;
        });

        return response()->json($hashedEducationCourses);
    }


    
    public function store(Request $request)
    {

        $Course_name = $request->name_course;
        $Hashed_Course_topic_id = $request->education_topic_id;
        $Hashed_Course_difficulty_id = $request->education_level_id;

        $Course_topic_id = numhash($Hashed_Course_topic_id);
        $Course_difficulty_id = numhash($Hashed_Course_difficulty_id);

        // Check if the name_level already exists and delete_flg is 0
        $existingCourse = EducationCourse::where('name_course', $request->name_course)
            ->where('delete_flg', 0)
            ->exists();
        
        if ($existingCourse) {
            // Return 1 if name_level already exists
            echo 1;
            return;
        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name_course' => 'required|string|max:255'
            // Add other validation rules here if needed
        ]);

        // Create a new EducationLevel instance
        $educationCourse = new EducationCourse();
        $educationCourse->name_course = $validatedData['name_course'];


        // Set the current date and time for created_date and updated_date
        $now = Carbon::now();
        $educationCourse->created_date = $now;
        $educationCourse->updated_date = $now;

        // Set other attributes here if needed
        $educationCourse->education_topic_id = $Course_topic_id;
        $educationCourse->education_level_id = $Course_difficulty_id;


        // Save the EducationLevel instance
        $educationCourse->save();

        // Return a success message or perform any other action
        return 0;
    }

    public function update(Request $request, $id) {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationCourse = EducationCourse::findOrFail($hashedID);

        $Hashed_Course_topic_id = $request->education_topic_id;
        $Hashed_Course_difficulty_id = $request->education_level_id;

        $Course_topic_id = numhash($Hashed_Course_topic_id);
        $Course_difficulty_id = numhash($Hashed_Course_difficulty_id);



        // Check if the name_level already exists and delete_flg is 0 for other records except the current one being updated
        $existingCourse = EducationCourse::where('name_course', $request->name_course)
            ->where('delete_flg', 0)
            ->where('id', '!=', $hashedID) // Exclude the current education level being updated
            ->exists();
        
        if ($existingCourse) {
            // Return 1 if name_level already exists
            echo 1;
            return;
        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name_course' => 'required|string|max:255',
            // Add other validation rules here if needed
        ]);

        // Update the education level's name
        $educationCourse->name_course = $validatedData['name_course'];

        // Set other attributes here if needed
        $educationCourse->education_topic_id = $Course_topic_id;
        $educationCourse->education_level_id = $Course_difficulty_id;


        $educationCourse->save();

        // Return a success message or perform any other action
        return 0;
    }   

    public function delete($id) {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationCourse = EducationCourse::findOrFail($hashedID);

        // Update delete_flg to mark as deleted (soft delete)
        $educationCourse->delete_flg = 1;
        $educationCourse->save();

        // Return a success message or perform any other action
        return 0;
    }
}



