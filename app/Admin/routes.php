<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('authors', AuthorController::class);
    $router->get('/api/authors', 'AuthorController@authors');

    $router->resource('posts', PostController::class);

    $router->resource('comments', CommentController::class);
    $router->get('/api/posts', 'PostController@authors');

});
