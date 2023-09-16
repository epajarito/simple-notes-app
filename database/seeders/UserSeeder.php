<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'test',
            'email' => 'test@me.com',
            'password' => 'password',
            'email_verified_at' => now()
        ]);

        User::factory(100)
            ->hasNotes(rand(50,75))
            ->create();
    }
}
