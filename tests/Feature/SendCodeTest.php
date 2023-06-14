<?php
namespace Tests\Feature;

use App\Helpers\CodeGenerator;
use App\Mail\VerificationCode;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;


class SendCodeTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use DatabaseMigrations;

    public function test_sent_verification_code():void
    {
        Mail::fake();

//         Create a mock instance of the class
        $mock = \Mockery::mock(CodeGenerator::class);

        // Mock the method call
        $mock->shouldReceive('handle')
            ->once()
            ->andReturn('123456');

        $this->app->instance(CodeGenerator::class, $mock);

        $user = User::factory()->create();

        $data = [
            'data' => $user->email
        ];

        $this->actingAs($user)
            ->post('verification-code', $data);

        Mail::assertQueued(VerificationCode::class, function ($mail) use ($user){
            return dump($mail->verification_code) == 123456
                && $mail->hasTo($user->email);
        });
    }
}
