<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationModule;
use App\Models\EducationCourse;
use Illuminate\Support\Carbon; // Import Carbon


class EducationModuleController extends Controller
{

    public function page($id)
    {

         // Find the education level by ID
        $hashedID = numhash($id);
        $educationModule = EducationModule::findOrFail($hashedID);


        return response()->json($educationModule);

       
    }

    public function index($course_id) {

        $hashed_course_id = numhash($course_id);


        $educationCourseModule = EducationModule::where('delete_flg', 0)
        ->where('education_course_id', $hashed_course_id)
        ->get(); // Fetch blocked users

        $hashedEducationCourseModule = $educationCourseModule->map(function ($educationCourseModule) {
            
            $educationCourseModule->id = numhash($educationCourseModule->id);

            $educationCourseModule->course_name = EducationCourse::find($educationCourseModule->education_course_id)->name_course;

            $educationCourseModule->education_course_id = numhash($educationCourseModule->education_course_id);

            return $educationCourseModule;
        });

        

        return response()->json($hashedEducationCourseModule);
    }

    public function store(Request $request) {

        $Hashed_Course_id = $request->education_course_id;

        $Course_id = numhash($Hashed_Course_id);

        // Check if the name_level already exists and delete_flg is 0
        $existingModule = EducationModule::where('name_module', $request->name_module)
            ->where('delete_flg', 0)
            ->exists();
        
        if ($existingModule) {
            // Return 1 if name_level already exists
            echo 1;
            return;
        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name_module' => 'required|string|max:255'
            // Add other validation rules here if needed
        ]);

        // // Create a new EducationLevel instance
        $educationCourse = new EducationModule();
        $educationCourse->name_module = $validatedData['name_module'];

        // // Set the current date and time for created_date and updated_date
        $now = Carbon::now();
        $educationCourse->created_date = $now;
        $educationCourse->updated_date = $now;

        // // Set other attributes here if needed
        $educationCourse->education_course_id = $Course_id;

        
        // // Save the EducationLevel instance
        $educationCourse->save();

        // Return a success message or perform any other action
        return 0;
    }

    public function update(Request $request, $id) {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationCourseModule = EducationModule::findOrFail($hashedID);

        $Hashed_Course_id = $request->education_Course_id;

        $Coursec_id = numhash($Hashed_Course_id);

        // Check if the name_level already exists and delete_flg is 0 for other records except the current one being updated
        $existingLevel = EducationModule::where('name_module', $request->name_module)
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
            'name_module' => 'required|string|max:255',
            // Add other validation rules here if needed
        ]);

        // Update the education level's name
        $educationCourseModule->name_module = $validatedData['name_module'];

         // Set other attributes here if needed
         $educationCourseModule->education_course_id = $Coursec_id;


        $educationCourseModule->save();

        // Return a success message or perform any other action
        return 0;
    }   

    public function delete($id) {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationCourseModule = EducationModule::findOrFail($hashedID);

        // Update delete_flg to mark as deleted (soft delete)
        $educationCourseModule->delete_flg = 1;
        $educationCourseModule->save();

        // Return a success message or perform any other action
        return 0;
    }

}



