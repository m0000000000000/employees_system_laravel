<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
        'username' => 'mohamed mossad',
            'first_name' => "mohamed",
            'last_name' => "Mossad",
            'email' => 'super_admin@admin.com',
            'password' => Hash::make('admin@admin.com'),
            ]);
        $user->attachRole('super_admin');
        $user=User::create([
        'username' => 'Admin Admin',
            'first_name' => "Admin",
            'last_name' => "Admin",
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            ]);
        $user->attachRole('admin');
    }
}
