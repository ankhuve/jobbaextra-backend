<?php

use Illuminate\Database\Seeder;

class FeaturedCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\FeaturedCompany', 5)->create();
    }
}
