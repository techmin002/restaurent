<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Upload\Entities\Upload;
use Modules\User\Rules\MatchCurrentPassword;

class ProfileController extends Controller
{

    public function edit()
    {
        return view('user::profile');
    }


    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id()
        ]);

        $imageName = '';
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/users'), $imageName);
        } else {
            $imageName = auth()->user()->image;
        }

        auth()->user()->update([
            'name'  => $request->name,
            'email' => $request->email,
            'image' => $imageName
        ]);

        return back()->with('success', 'Updated Successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'  => ['required', 'max:255', new MatchCurrentPassword()],
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return back()->with('success', 'Password Changed Successfully');
    }
}
