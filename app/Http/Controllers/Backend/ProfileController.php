<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('backend.profile.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'email'=> 'required|string|email|max:255|unique:users,email,'. Auth::id(),
            // 'password'=> 'nullable|confirmed|string|min:8',
            'avatar'=> 'nullable|image',
          ]);
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        
        if ($request->hasFile('avatar')) {
            $user->addMedia($request->avatar)->toMediaCollection('avatar');
        }
        notify()->success('Profile Updated','Successfully');
        return back();
    }

    public function changePassword()
    {
        return view('backend.profile.security');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'=> 'required',
            'password'=> 'required|confirmed',
          ]);

        $user = Auth::user();
        $hashePassword = $user->password;
        if(Hash::check($request->current_password, $hashePassword)) {
            if (!Hash::check($request->password, $hashePassword)) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
                Auth::logout();
                // notify('Pasword Changed','Success');
                return redirect()->route('login');

            } else {
                notify()->warning('New Password Can Not be The Same as old Password','Warning'); 
            }

        } else {
            notify()->error('Current Password Not Match','Error');
        }

        return back();
    }
}
