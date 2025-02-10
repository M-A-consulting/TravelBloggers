<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->id = Str::uuid();
        $user->first_name = 'super';
        $user->last_name = 'admin';
        $user->name = 'super_admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('password123');
        // $user->role = 'super-admin';
        $user->save();
    }
}
