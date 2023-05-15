<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nette\Schema\ValidationException;

class SessionsController extends Controller
{
    public function logout()
    {
        auth()->logout();
        return redirect('/posts');
    }

    public function create()
    {
        return view('login');
    }

    public function login()
    {
        $attributes = \request()->validate([
            'email'=> 'required|email',
            'password' => 'required'
        ]);

       if ( auth()->attempt($attributes))
       {
           return redirect('/posts');
       }

       throw \Illuminate\Validation\ValidationException::withMessages(['email'=> 'The Provided email or password is incorrect']);
/***Alternative way
       return back()->withInput()->withErrors(['email'=> 'The Provided email or password is incorrect']);
***/


    }

}
