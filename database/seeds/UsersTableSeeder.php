<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password        = str_random(32);
        $admin           = \Personals\User\User::create([
            'name'  => 'admin',
            'email' => 'change-me@example.org',
        ]);
        $admin->password = bcrypt($password);


        echo "\e[0;30;46m                                           \e[0m\n";
        echo "\e[0;30;46m   \e[0;30;43m Administrator Username:             \e[0;30;46m   \e[0m\n";
        echo "\e[0;30;46m   \e[1;33;40m   change-me@example.org             \e[0;30;46m   \e[0m\n";
        echo "\e[0;30;46m                                           \e[0m\n";
        echo "\e[0;30;46m   \e[0;30;43m Administrator Password:             \e[0;30;46m   \e[0m\n";
        echo "\e[0;30;46m   \e[1;33;40m   $password  \e[0;30;46m   \e[0m\n";
        echo "\e[0;30;46m                                           \e[0m\n";

    }
}
