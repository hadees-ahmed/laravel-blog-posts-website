<?php

namespace App\Policies;

trait BeforeTrait
{
    public function before($user): bool|null
    {
        return $user->is_Admin ? true : null;
    }

}
