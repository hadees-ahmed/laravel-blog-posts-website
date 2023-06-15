<?php

namespace App\Policies;


use App\Models\User;

class UserPolicy
{

    //use BeforeTrait;

    public function before()
    {
        if (auth()->user()->is_Admin){
            return null;
        }
        return false;
    }

    public function banOrUnban(User $loggedInUser, User $userToBan)
    {
        return $loggedInUser->id != $userToBan->id && !$loggedInUser->is_banned;
    }
    public function promoteOrDemote(User $loggedInUser, User $userToBan)
    {
        return $loggedInUser->id != $userToBan->id && !$loggedInUser->is_banned;
    }
}
