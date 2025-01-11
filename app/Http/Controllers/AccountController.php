<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use Single;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserAddress;
use App\View\Components\Account\WishlistItems;
use App\View\Components\Inc\Pagination;

class AccountController extends Controller
{
    public function account()
    {
        $user = Auth::user();

        if (empty($user)) {
            abort(404);
        }

        return view("pages.account", [
            
        ]);
    }

    public function editUser(UserEditRequest $r)
    {
        $data = $r->validated();  // Get validated data from the request

        $user = Auth::user();

        // Update user details
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['avatar'])) {
            // Delete old avatar if it exists (optional)
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
    
            // Extract the base64 data (remove the "data:image/{type};base64," prefix)
            $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $data['avatar']);
    
            // Decode the base64 string
            $imageData = base64_decode($base64Image);
    
            // Generate a unique file name for the avatar
            $avatarFileName = time() . '.png';  // Assuming png format, adjust as necessary
    
            // Save the decoded image to the 'public/avatars' directory
            file_put_contents(public_path('avatars/' . $avatarFileName), $imageData);
    
            // Set the avatar path to be saved in the user model
            $user->avatar = 'avatars/' . $avatarFileName;
        }

        // Save updated user information
        $user->save();

        // Return success response
        return response()->json(['success' => true, 'message' => 'Profile updated successfully'], 200);
    }
}
