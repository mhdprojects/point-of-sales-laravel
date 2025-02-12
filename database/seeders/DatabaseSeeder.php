<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        $email = 'admin@mhdprojects.com';

        $user = User::query()->firstOrNew([
            'email' => $email,
        ]);
        $user->email    = $email;
        $user->password = Hash::make('password');
        $user->name     = 'Admin';
        $user->email_verified_at = now();
        $user->save();
    }
}
