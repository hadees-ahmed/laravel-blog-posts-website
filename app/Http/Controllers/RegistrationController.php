<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\StoreUserRequest;
use App\Mail\SignUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(StoreRegistrationRequest $request)
    {
        /* alternative way */
//            DB::table('users')->insert(
//                [
//                    'username' => $request->get('username'),
//                    'email' => $request->get('email'),
//                    'password' => bcrypt($request->get('password')),
//                    'created_at' => now()
//                ]
//            );
        $user =  User::create($request->validated());
        //is used to send welcome message to the user that is created
        //also queued the action for better user experience.
        Mail::to($user->email)->send(new SignUp($user));
        auth()->login($user);
        session()->flash('success','Your account has been created');
        return redirect('/posts');
    }
}
