<?php

namespace App\Console\Commands;

use App\Models\Admin\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminCommand extends Command
{
    protected $signature = 'make:admin';
    protected $description = 'একটা নতুন অ্যাডমিন অ্যাকাউন্ট তৈরি করে (সিকিউর CLI পদ্ধতি)';

    public function handle(): int
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password(min 8 character))');
        $confirm = $this->secret('Confirm Password');

        $validator = Validator::make(
            compact('name', 'email', 'password'),
            [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'email', 'unique:admins,email'],
                'password' => ['required', 'string', 'min:8'],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return self::FAILURE;
        }

        if ($password !== $confirm) {
            $this->error('পাসওয়ার্ড দুইবার মিলছে না।');
            return self::FAILURE;
        }

        Admin::create([
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
        ]);

        $this->info("অ্যাডমিন অ্যাকাউন্ট তৈরি হয়েছে: {$email}");
        return self::SUCCESS;
    }
}