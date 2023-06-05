<?php

namespace App\Http\Controllers;

use App\Mail\SignUp;
use App\Mail\VerificationCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class PasswordController extends Controller
{
    public function create()
    {
      return view('recover-password');
    }

    public function sendVerificationCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email',$request->get('email') )->first();
        $verification_code = random_int(1000, 9999);

        Mail::to($user->email)
            ->send(new VerificationCode($user,$verification_code));
        session()->put('verification_code', $verification_code);
        session()->put('user', $user);
        return redirect()->route('verification.code.enter');
    }

    public function enterVerificationCode()
    {
        return view('verification-code-and-new-password', [
            'verification_code'=> session()->get('verification_code'),
            'user' => session()->get('user')
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required|numeric|digits:4' ]);

        if ($request->get('code') != session()->get('verification_code')) {
            return redirect()->back()->withErrors(['message' => 'Something went wrong. Please try again.']);
        }

        return redirect()->route('enter.new.password');
    }
    public function enterNewPassword()
    {
        return view('verification-code-and-new-password');
    }
    public function update(Request $request)
    {
        $request->validate(['password' =>'required|min:3']);

        $user = session()->get('user');

        // delete data from session
        Session::forget(['verification_code', 'user', 'email']);

        $user->update(['password' => $request->get('password')]);
        session()->flash('success','Your new password is updated');
        return redirect('/login');
    }
}
