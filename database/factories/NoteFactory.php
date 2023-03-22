<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'note'          => encrypt('secret message', $serialize = false),
            'password'      => Hash::make('secret'),
            'expiry_date'   => now()->addDays(7),
            'token'         => 'token',
        ];
    }
}
