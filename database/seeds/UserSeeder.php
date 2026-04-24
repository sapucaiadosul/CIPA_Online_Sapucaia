<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UserSeeder extends Seeder

{
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'name'=> 'Admin',
                    'email'=> 'admin@gmail.com',
                    'password'=> bcrypt('12345678'),
                    'cpf' => '03801813711',
                    'nivel'=> '3'
                ],
                [
                    'name'=> 'Desenvolvedor',
                    'email'=> 'desenvolvedor@gmail.com',
                    'password'=> bcrypt('123456789'),
                    'cpf' => '50602179068',
                    'nivel'=> '3'
                ]
            ]
        );
    }
}