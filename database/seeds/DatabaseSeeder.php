<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    protected $toTruncate = ['users', 'jobs', 'featured_companies'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($this->toTruncate as $table)
        {
            DB::table($table)->truncate();
        }

         $this->call(UsersTableSeeder::class);
         $this->call(JobsTableSeeder::class);
         $this->call(FeaturedCompaniesTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
