<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
        ]);
    }
}