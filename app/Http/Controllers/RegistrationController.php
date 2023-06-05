<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password'=>'required|max:50|min:3'
        ]);


//            DB::table('users')->insert(
//                [
//                    'username' => $request->get('username'),
//                    'email' => $request->get('email'),
//                    'password' => bcrypt($request->get('password')),
//                    'created_at' => now()
//                ]
//            );
        $user =  User::create($attributes);
        //is used to send welcome message to the user that is created
        //also queued the action for better user experience.
        Mail::to($user->email)->send(new SignUp($user));
        auth()->login($user);
        session()->flash('success','Your account has been created');
        return redirect('/posts');
    }
}
