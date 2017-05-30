<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Page')->create([
            'title' => 'Startsida',
            'published_at' => Carbon::now(),
            'id' => 3
        ]);

        factory('App\Page')->create([
            'title' => 'Om oss',
            'published_at' => Carbon::now(),
            'id' => 4
        ]);

        factory('App\Page')->create([
            'title' => 'Kontakt',
            'published_at' => Carbon::now(),
            'id' => 5
        ]);
    }
}
