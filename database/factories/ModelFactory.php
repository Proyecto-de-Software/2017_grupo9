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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
/*$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
*/
$factory->define(App\Patient::class, function ($faker) {
	$genders = array('m', 'f');
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'address' => $faker->streetAddress,
        'phone' => '234440',
        'birthdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'gender' => $genders[array_rand($genders, 1)],
        'document_number' => $faker->numberBetween($min = 30000000, $max = 40000000),

    ];
});

$factory->define(App\User::class, function ($faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => Hash::make('123'),
        'username' => $faker->userName,
        'active' => true,
        'remember_token' => str_random(10),
    ];
});

?>
