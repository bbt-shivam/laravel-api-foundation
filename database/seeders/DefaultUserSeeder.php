<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    use WithoutModelEvents;
  
    public function run(): void
    {
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 's@s.com',
            'password' => Hash::make('123456')
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'a@a.com',
            'password' => Hash::make('123456'),
        ]);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'u@u.com',
            'password' => Hash::make('123456'),
        ]);
        
        $superAdmin->assignRole('super-admin');
        $admin->assignRole('admin');
        $user->assignRole('user');
    }
}
