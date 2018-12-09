<?php

use Illuminate\Database\Seeder;

class PageContentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\PageContent')->create([
            'page_id' => 3,
            'type' => 'content'
        ]);

        factory('App\PageContent')->create([
            'page_id' => 4,
            'type' => 'hero'
        ]);

        factory('App\PageContent')->create([
            'page_id' => 4,
            'type' => 'content'
        ]);

        factory('App\PageContent')->create([
            'page_id' => 5,
            'type' => 'contact'
        ]);
    }
}
