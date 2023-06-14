<?php

namespace Tests\Unit\Helpers;

use App\Helpers\CodeGenerator;
use Tests\TestCase;

class PasswordGeneratorTest extends TestCase
{
    public function test_that_the_code_is_generated(): void
    {
        $verificationCode = (new CodeGenerator())->handle();

        $this->assertTrue(6 == strlen($verificationCode));
        $this->assertTrue(is_numeric($verificationCode));
    }
}
