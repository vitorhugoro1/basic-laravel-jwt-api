<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    $title = $faker->text;
    return [
        'post_title' => $title,
        'user_id' => function () {
            return factory(\App\Models\User::class)->create();
        },
        'content' => $faker->realText(),
    ];
});
