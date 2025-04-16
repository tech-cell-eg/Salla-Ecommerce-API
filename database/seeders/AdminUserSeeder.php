<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Change this password!
            'email_verified_at' => now(),
        ]);
         // Create admin role if it doesn't exist
         $adminRole = Role::firstOrCreate(['name' => 'admin']);

         // Assign admin role to user
         $admin->assignRole($adminRole);
    }
}
