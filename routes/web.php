<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;


use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;


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

