<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\EducationModule;
// use App\Models\EducationCourse;
use App\Models\EducationLesson;
use Illuminate\Support\Carbon; // Import Carbon


class EducationLessonController extends Controller
{

    public function page($id)
    {

         // Find the education level by ID
        $hashedID = numhash($id);
        $educationLesson = EducationLesson::findOrFail($hashedID);


        return response()->json($educationLesson);

       
    }

    public function index($module_id) {

        $hashed_Module_id = numhash($module_id);


        $educationCourseLessons = EducationLesson::where('delete_flg', 0)
        ->where('education_module_id', $hashed_Module_id)
        ->get(); // Fetch blocked users

        $hashedEducationLesson = $educationCourseLessons->map(function ($educationCourseLesson) {
            $educationCourseLesson->id = numhash($educationCourseLesson->id);
            return $educationCourseLesson;
        });

        

        return response()->json($hashedEducationLesson);
    }

    public function store(Request $request) {

        $Hashed_lesson_id = $request->id_course_module;
        $time_lesson = $request->time_lesson;
        $name_lesson = $request->name_lesson;
        $content_lesson = $request->content_lesson;

        $Module_id = numhash($Hashed_lesson_id);

        // return $content_lesson;

        

        // Check if the name_level already exists and delete_flg is 0
        $existingLesson = EducationLesson::where('name_lesson', $request->name_lesson)
            ->where('delete_flg', 0)
            ->exists();
        
        if ($existingLesson) {
            // Return 1 if name_level already exists
            echo 1;
            return;
        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name_lesson' => 'required|string|max:255'
            // Add other validation rules here if needed
        ]);

        // // Create a new EducationLevel instance
        $educationLesson = new EducationLesson();
        $educationLesson->name_lesson = $validatedData['name_lesson'];

        // // Set the current date and time for created_date and updated_date
        $now = Carbon::now();
        $educationLesson->created_date = $now;
        $educationLesson->updated_date = $now;

        // // Set other attributes here if needed
        $educationLesson->education_module_id = $Module_id;
        $educationLesson->time_lesson = $time_lesson;
        $educationLesson->content_lesson = $content_lesson;


        
        // // Save the EducationLevel instance
        $educationLesson->save();

        // Return a success message or perform any other action
        return 0;
    }

    public function update(Request $request, $id) {
        // Find the education level by ID
        $hashedID = numhash($id);

        $Hashed_lesson_id = $request->id_course_module;
        $time_lesson = $request->time_lesson;
        $name_lesson = $request->name_lesson;
        $content_lesson = $request->content_lesson;

        $Module_id = numhash($Hashed_lesson_id);

        $educationLesson = EducationLesson::findOrFail($hashedID);


        $existingLesson = EducationLesson::where('name_lesson', $request->name_lesson)
            ->where('delete_flg', 0)
            ->where('id', '!=', $hashedID) // Exclude the current education level being updated
            ->exists();
        
        if ($existingLesson) {
            // Return 1 if name_level already exists
            echo 1;
            return;
        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name_lesson' => 'required|string|max:255'
            // Add other validation rules here if needed
        ]);

        // // Create a new EducationLevel instance
        $educationLesson->name_lesson = $validatedData['name_lesson'];

        // // Set the current date and time for created_date and updated_date
        $now = Carbon::now();
        $educationLesson->updated_date = $now;

        // // Set other attributes here if needed
        $educationLesson->education_module_id = $Module_id;
        $educationLesson->time_lesson = $time_lesson;
        $educationLesson->content_lesson = $content_lesson;

        // // Save the EducationLevel instance
        $educationLesson->save();

        // Return a success message or perform any other action
        return 0;
    }   

    public function delete($id) {
        // Find the education level by ID
        $hashedID = numhash($id);
        $educationCourseLesson = EducationLesson::findOrFail($hashedID);

        // Update delete_flg to mark as deleted (soft delete)
        $educationCourseLesson->delete_flg = 1;
        $educationCourseLesson->save();

        // Return a success message or perform any other action
        return 0;
    }

}



