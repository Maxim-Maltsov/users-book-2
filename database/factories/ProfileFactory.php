<?php

use Faker\Generator as Faker;

$factory->define( App\Profile::class, function (Faker $faker) {

    return [

        'user_id' => factory(App\User::class),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'job' => $faker->jobTitle,
        'status' => 'online',
        'avatar' => null,
        'vk' => 'https://vk.com',
        'telegram' => 'https://telegram.org',
        'instagram' => 'https://www.instagram.com',
    ];
});



 