<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        $hashId = numhash($id);
        
        // Check if the provided email belongs to the same user being updated
        $userWithEmail = User::where('email', $request->email)->first();
        if ($userWithEmail && $userWithEmail->id != $hashId) {
            // Return 1 if email already exists for another user
            echo 1;
            return;
        }

        // Check if the provided phone number belongs to another user
        $existingPhoneNo = User::where('phone', $request->phone)->first();
        if ($existingPhoneNo && $existingPhoneNo->id != $hashId) {
            // Return 2 if phone number already exists for another user
            echo 2;
            return;
        }

        // Update the user record
        $user = User::findOrFail($hashId);
        $user->update($request->all());

        // Return a success message
        echo 0;
    }
}

