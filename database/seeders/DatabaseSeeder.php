<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Superadmins
        User::create([
            'name' => 'Super Admin 1',
            'email' => 'super1@gmail.com',
            'password' => Hash::make('super1'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Super Admin 2',
            'email' => 'super2@gmail.com',
            'password' => Hash::make('super2'),
            'role' => 'superadmin',
        ]);

        // Admins
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('admin1'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('admin2'),
            'role' => 'admin',
        ]);
    }

}
