<?php

namespace App\Actions\Team;


use App\Models\User;
use Illuminate\Support\Facades\Hash;



class CreateTeamMember
{


    public function handle(
        array $data
    ): User {


        return User::create([


            'name'=>$data['name'],


            'email'=>$data['email'],


            'phone'=>$data['phone'] ?? null,


            'role'=>$data['role'],


            'password'=>Hash::make(
                $data['password']
            ),


            'is_active'=>true,


            'is_logged_in'=>false,


        ]);

    }


}