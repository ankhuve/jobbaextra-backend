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
        // Create an admin account
        factory('App\User')->create([
            'name' => 'Erik Forsberg',
            'email' => 'erik.c.forsberg@gmail.com',
            'password' => bcrypt('password'),
            'remember_token' => str_random(10),
            'role' => 3,
            'paying' => random_int(0,1),
        ]);

        // Create companies
        factory('App\User', 49)->create();

        // Create end users, some with Notes
        factory('App\User', 20)->create([
            'role' => 1,
            'paying' => 0,
        ])->each(
            function($user) {
                if (random_int(0, 1) == 1) {
                    factory(App\Note::class)->create(
                        ['user_id' => $user->id]
                    );
                }
            }
        );
    }
}
