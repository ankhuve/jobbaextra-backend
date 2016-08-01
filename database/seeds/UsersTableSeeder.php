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
        factory('App\User')->create([
            'name' => 'Erik Forsberg',
            'email' => 'erik.c.forsberg@gmail.com',
            'password' => bcrypt('password'),
            'remember_token' => str_random(10),
            'role' => 3,
            'paying' => random_int(0,1),
        ]);

        factory('App\User', 49)->create();
    }
}
