<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Carbon\Carbon;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt('company'),
        'remember_token' => str_random(10),
        'role' => 2,
        'paying' => random_int(0,1),
        'paid_until' => Carbon::now()->addDays(random_int(1,30)),
    ];
});

$factory->define(App\Job::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->jobTitle,
        'user_id' => random_int(1,50),
        'work_place' => $faker->company,
        'type' => $faker->jobTitle,
        'county' => $faker->country,
        'municipality' => $faker->city,
        'description' => $faker->paragraph,
        'latest_application_date' => Carbon::now()->addDays(random_int(1,30)),
        'contact_email' => $faker->companyEmail,
        'published_at' => $faker->dateTime,
    ];
});

$factory->define(App\FeaturedCompany::class, function (Faker\Generator $faker) {
    return [
        'company_id' => random_int(1,50),
        'start_date' => $faker->dateTimeThisYear,
        'end_date' => $faker->dateTimeThisYear,
    ];
});

$factory->define(App\Page::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'published_at' => Carbon::now()
    ];
});

$factory->define(App\PageContent::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'content' => $faker->paragraphs(2, true)
    ];
});