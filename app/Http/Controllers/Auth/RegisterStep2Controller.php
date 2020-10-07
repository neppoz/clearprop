<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

class RegisterStep2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showForm()
    {
        $user = User::findOrFail(auth()->user()->id);
        if ($user->roles->contains(User::IS_ADMIN)) {
            return redirect()->route('admin.home');
        }

        if ($user->roles->contains(User::IS_MANAGER)) {
            return redirect()->route('admin.home');
        }

        if (empty($user->privacy_confirmed_at) and $user->roles->contains(User::IS_MEMBER)) {
            return view('auth.register_step2', compact('user'));
        } else {
            return redirect()->route('pilot.welcome');
        }
    }

    public function postForm(Request $request)
    {
        auth()->user()->update($request->only([
            'taxno',
            'phone_1',
            'phone_2',
            'address',
            'city',
            'license',
            'medical_due',
            'privacy_confirmed_at'
        ]));

        User::findOrFail(auth()->user()->id)->roles()->sync(User::IS_MEMBER);

        return redirect()->route('pilot.welcome');
    }
}
