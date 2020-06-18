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
        if (empty($user->license) or empty($user->medical_due)) {
            return view('auth.register_step2', compact('user'));
        } else {
            return redirect()->route('admin.home');
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
            'medical_due'
        ]));

        User::findOrFail(auth()->user()->id)->roles()->sync(User::IS_MEMBER);

        return redirect()->route('admin.home');
    }
}
