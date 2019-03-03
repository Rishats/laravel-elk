<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $commentable = [
        App\Models\Post::class,
        App\Models\Comment::class,
    ];// Add new noteables here as we make them

    $commentableType = $faker->randomElement($commentable);
    $commentable = factory($commentableType)->create();
    $author = factory(App\Models\Author::class)->create();

    return [
        'author_id' => $author->id,
        'commentable_id' => $commentable->id,
        'commentable_type' => $commentableType,
        'body' => $faker->realText(rand(10, 300)),
    ];
});
