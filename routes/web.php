<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\EducationLevel;
use App\Models\EducationTopic;


use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EducationLevelController;
use App\Http\Controllers\EducationTopicController;
use App\Http\Controllers\EducationCourseController;
use App\Http\Controllers\EducationModuleController;
use App\Http\Controllers\EducationLessonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::get('/members', function () {
    return view('member/members');
});


Route::get('/contents', function () {
    return view('contents/contents');
});


Route::get('/contents_homepage', function () {
    return view('contents/Homepage/contents_homepage');
});




Route::get('/members/user-profile/{id}', function () {
    return view('member/user_profile');
});

Route::get('/members/user-details/{id}', function () {
    return view('member/user_details');
});

Route::get('/members/user-security/{id}', function () {
    return view('member/user_security');
});


Route::get('/api/members/user-profile/{id}', function ($id) {

    // Hash the user ID
    $hashedId = numhash($id);


    $user = User::find($hashedId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Remove the password from the user object
    unset($user->password);

    // Return the user information along with hashed ID
    return response()->json(['user' => $user]);
});


Route::get('/api/members/{status}', function ($status) {
    if ($status === 'blocked') {
        $users = User::where('block_flg', 1)->get(); // Fetch blocked users
    } else {
        $users = User::where('block_flg', 0)->get(); // Fetch unblocked users
    }

    $hashedUsers = $users->map(function ($user) {
        $user->id = numhash($user->id);
        return $user;
    });

    return response()->json($hashedUsers);
});




Route::post('/members/user-block/{id}', [MemberController::class, 'blockUser']);

Route::post('/members/user-unblock/{id}', [MemberController::class, 'unblockUser']);

Route::put('/api/members/user-update/{id}', [UserController::class, 'update']);





/* Education Management Dashboard */
Route::get('/education_dashboard', function () {
    return view('education/education');
});


/* ---------------------------------------- Education Topic Start ---------------------------------------- */
    Route::get('/education', function () {
        return view('education/educationtopic');
    });

    /* Page Data */
    Route::get('/api/page-education-topic/{id}', [EducationTopicController::class, 'page']);

    /* CRUD Start */

        /* Create */
        Route::post('/api/add-education-topic', [EducationTopicController::class, 'store'])->name('education-topic.store');

        /* Retrieve */
        Route::get('/api/view-education-topic', [EducationTopicController::class, 'index']);

        /* Update */
        Route::put('/api/update-education-topic/{id}', [EducationTopicController::class, 'update'])->name('education-level.update');

        /* Delete */
        Route::delete('/api/delete-education-topic/{id}', [EducationTopicController::class, 'delete'])->name('education-level.delete');

    /* Education CRUD End */

/* ---------------------------------------- Education Topic End ---------------------------------------- */



/* ---------------------------------------- Education Level Start ---------------------------------------- */

    Route::get('/education_level/{topic}', function ($topic) {
        return view('education/educationlevel');
    });

    /* Page Data */
    Route::get('/api/page-education-level/{id}', [EducationLevelController::class, 'page']);

    /* CRUD Start */

        /* Create */
        Route::post('/api/add-education-level', [EducationLevelController::class, 'store'])->name('education-level.store');

        /* Retrieve */
        Route::get('/api/view-education-level', [EducationLevelController::class, 'index']);

        /* Update */
        Route::put('/api/update-education-level/{id}', [EducationLevelController::class, 'update'])->name('education-level.update');

        /* Delete */
        Route::delete('/api/delete-education-level/{id}', [EducationLevelController::class, 'delete'])->name('education-level.delete');

    /* Education CRUD End */

/* ---------------------------------------- Education Level End ---------------------------------------- */


/* ---------------------------------------- Education Course Start ---------------------------------------- */

    Route::get('/education_course/{topic}/{level}', function ($topic, $level) {
        return view('education/educationcourse');
    });

    /* Page Data */
    Route::get('/api/page-education-course/{id}', [EducationCourseController::class, 'page']);


    /* CRUD Start */

        /* Create */
        Route::post('/api/add-education-course', [EducationCourseController::class, 'store'])->name('education-course.store');

        /* Retrieve */
        Route::get('/api/view-education-course/{topic_id}/{difficulty_id}', [EducationCourseController::class, 'index']);

        /* Update */
        Route::put('/api/update-education-course/{id}', [EducationCourseController::class, 'update'])->name('education-course.update');

        /* Delete */
        Route::delete('/api/delete-education-course/{id}', [EducationCourseController::class, 'delete'])->name('education-course.delete');

    /* Education CRUD End */

/* ---------------------------------------- Education Course End ---------------------------------------- */


/* ---------------------------------------- Education Module Start ---------------------------------------- */

    Route::get('/education_modules/{topic}/{level}/{course}', function ($topic, $level, $course) {
        return view('education/educationmodule');
    });

    /* Page Data */
    Route::get('/api/page-education-module/{id}', [EducationModuleController::class, 'page']);

    /* CRUD Start */

        /* Create */
        Route::post('/api/add-education-module', [EducationModuleController::class, 'store'])->name('education-module.store');


        /* Retrieve */
        Route::get('/api/view-education-module/{course_id}', [EducationModuleController::class, 'index']);

        /* Update */
        Route::put('/api/update-education-module/{id}', [EducationModuleController::class, 'update'])->name('education-module.update');


        /* Delete */
        Route::delete('/api/delete-education-module/{id}', [EducationModuleController::class, 'delete'])->name('education-module.delete');

    /* Education CRUD End */

/* ---------------------------------------- Education Module End ---------------------------------------- */

/* ---------------------------------------- Education Lessons Start ---------------------------------------- */

    Route::get('/education_lesson/{topic}/{level}/{course}/{module}', function ($topic, $level, $course, $module) {
        return view('education/educationlesson');
    });

    /* Add Content Page */
    Route::get('/education_add_lesson/{topic}/{level}/{course}/{module}', function ($topic, $level, $course, $module) {
        return view('education/educationAddlesson');
    });


    /* View Content Page */
    Route::get('/education_view_lesson/{topic}/{level}/{course}/{module}/{id}', function ($topic, $level, $course, $module, $id) {
        return view('education/educationViewlesson');
    });

    /* View Update Page */
    Route::get('/education_update_lesson/{topic}/{level}/{course}/{module}/{id}', function ($topic, $level, $course, $module, $id) {
        return view('education/educationUpdate');
    });


    


    /* Page Data */
    Route::get('/api/page-education-lesson/{id}', [EducationLessonController::class, 'page']);

    /* CRUD Start */

        /* Create */
        Route::post('/api/add-education-lesson', [EducationLessonController::class, 'store'])->name('education-lesson.store');
        
        /* Retrieve */
        Route::get('/api/view-education-lesson/{module_id}', [EducationLessonController::class, 'index']);

        /* Update */
        Route::put('/api/update-education-lesson/{id}', [EducationLessonController::class, 'update'])->name('education-lesson.update');

        /* Delete */
        Route::delete('/api/delete-education-lesson/{id}', [EducationLessonController::class, 'delete'])->name('education-lesson.delete');

    /* Education CRUD End */

/* ---------------------------------------- Education Lessons End ---------------------------------------- */