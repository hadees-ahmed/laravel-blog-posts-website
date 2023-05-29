<?php

namespace App\Http\Controllers;

use App\Mail\SignUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(){
//        Mail::to('hadeesahmed@yahoo.com')
//            ->send(new SignUp());

        dispatch(function (){
            logger('hello there');
        });

//        return new \App\Mail\SignUp(User::first());

    }
}
