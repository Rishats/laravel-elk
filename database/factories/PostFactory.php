<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    $author = factory(App\Models\Author::class)->create();

    return [
        'author_id' => $author->id,
        'title' => $faker->realText(rand(10,30)),
        'description' => $faker->realText(rand(30, 100)),
        'body' => $faker->realText(rand(100, 500)),
    ];
});
