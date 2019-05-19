<?php

namespace App\Http\Controllers;
// use App\User;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}
    public function profile()
{
    $user = Auth::user();

    return view('profile',compact('user',$user));
    }

    public function update_avatar(Request $request){

    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $user = Auth::user();

    $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();

    $request->avatar->storeAs('avatars',$avatarName);

    $user->avatar = $avatarName;
    $user->save();

    return back()
        ->with('success','You have successfully upload image.');

    }
}
