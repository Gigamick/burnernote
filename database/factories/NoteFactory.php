<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class NoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'note' => Crypt::encryptString('secret message'),
            'password' => null,
            'expiry_date' => now()->addDays(7),
            'token' => Str::uuid()->toString(),
            'user_id' => null,
        ];
    }
}
