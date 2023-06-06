<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:register-user {name?} {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username =  $this->argument('name');
        $email = $this->argument('email');

        if (!$username) {
            $username = $this->ask('Enter Username');
        }

        if (!$email) {
            $email = $this->ask('Enter Your Email');
        }

        $password = $this->secret('Create a Password');

        User::create([
            'name' => $username,
            'email' => $email,
            'password' => $password
        ]);

        $this->info('user was created successfully!');
    }
}
