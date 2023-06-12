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
        $verification_code = random_int(100000, 999999);

        Mail::to($user->email)
            ->send(new VerificationCode($user,$verification_code));
        session()->put('verification_code', $verification_code);
        session()->put('user', $user);
        return redirect()->route('verification.code.enter');
    }

    public function enterVerificationCode()
    {
        if (!session()->get('user') || !session()->get('verification_code')){
            abort(401);
        }
        return view('verification-code.new-password.form', [
            'verification_code'=> session()->get('verification_code'),
            'user' => session()->get('user')
        ]);
    }

    public function verifyCode(Request $request)
    {
        if ($request->get('code') != session()->get('verification_code')) {
            return redirect()->back()->withErrors(['message' => 'Something went wrong. Please try again.']);
        }
        $request->validate(['code' => 'required|numeric|digits:6' ]);
        \session()->put('code', $request->get('code'));
        return redirect()->route('enter.new.password');
    }
    public function enterNewPassword()
    {
        if (!session()->get('user') || session()->get('verification_code') != session()->get('code')){
            abort(401);
        }
        return view('verification-code.new-password.form');
    }
    public function update(Request $request)
    {
        if (!session()->get('user') || session()->get('verification_code') != session()->get('code')){
            abort(401);
        }
        $request->validate(['password' =>'required|min:3']);

        $user = session()->get('user');

        // delete data from session
        Session::forget(['verification_code', 'user', 'email']);

        $passwordUpdated = $user->update(['password' => $request->get('password')]);
        $passwordUpdated
            ?session()->flash('success','Your new password is updated')
            :session()->flash('failed','Something went wrong while updating your password please try again later');
        return redirect('/login');
    }
}
