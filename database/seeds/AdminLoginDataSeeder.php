<?php

use App\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminLoginDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();

        Admin::create([
            'email' => 'admin@admin.com',
            'name' => 'Admin',
            'password' => Hash::make('admin')
        ]);
    }
}
