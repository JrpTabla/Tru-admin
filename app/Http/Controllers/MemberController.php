<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function blockUser(Request $request, $id)
    {

        $hashUserId = numhash($id);

        // Find the user by ID
        $user = User::findOrFail($hashUserId);

        // Update the block_flg field to 1 (blocked)
        $user->update(['block_flg' => 1]);

        // You can return a response here if needed
        return response()->json(['message' => 'User blocked successfully']);
    }

    public function unblockUser(Request $request, $id)
    {

        $hashUserId = numhash($id);

        // Find the user by ID
        $user = User::findOrFail($hashUserId);

        // Update the block_flg field to 1 (blocked)
        $user->update(['block_flg' => 0]);

        // You can return a response here if needed
        return response()->json(['message' => 'User blocked successfully']);
    }
}
