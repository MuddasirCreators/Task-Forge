<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{

    public function run(): void
    {


        User::factory()->createMany([


            [
                'name'=>'Admin User',
                'email'=>'admin@taskforge.com',
                'password'=>Hash::make('password'),
                'role'=>'Admin',
                'is_active'=>true,
            ],


            [
                'name'=>'Manager One',
                'email'=>'manager1@taskforge.com',
                'password'=>Hash::make('password'),
                'role'=>'Manager',
                'is_active'=>true,
            ],


            [
                'name'=>'Manager Two',
                'email'=>'manager2@taskforge.com',
                'password'=>Hash::make('password'),
                'role'=>'Manager',
                'is_active'=>true,
            ],


            [
                'name'=>'Member One',
                'email'=>'member1@taskforge.com',
                'password'=>Hash::make('password'),
                'role'=>'Member',
                'is_active'=>true,
            ],


            [
                'name'=>'Member Two',
                'email'=>'member2@taskforge.com',
                'password'=>Hash::make('password'),
                'role'=>'Member',
                'is_active'=>true,
            ],


            [
                'name'=>'Member Three',
                'email'=>'member3@taskforge.com',
                'password'=>Hash::make('password'),
                'role'=>'Member',
                'is_active'=>true,
            ],


        ]);

    }

}