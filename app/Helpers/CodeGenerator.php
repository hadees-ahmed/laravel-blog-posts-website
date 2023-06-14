<?php

namespace App\Helpers;

class CodeGenerator
{
    public function handle()
    {
        return random_int(100000, 999999);
    }
}
