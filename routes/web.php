<?php

/** @var \Laravel\Lumen\Routing\Router $router */


use Illuminate\Support\Facades\Route;

$router->group(['prefix' => 'api'], function () use ($router) {


    $router->get('books', 'BookController@showAllBook');
    $router->post('user/login', 'ContactController@login');
    $router->post('user/register', 'ContactController@create');
    $router->post('logout', 'ContactController@logout');


    $router->group(['middleware' => 'jwt.verify'], function () use ($router) {
        //user

        $router->get('users', 'ContactController@showAllUser');
        $router->get('user', 'ContactController@getAuthUser');
        $router->put('user/update/{id}', 'ContactController@update');
        $router->delete('user/delete/{id}', 'ContactController@delete');

        //book
        $router->group(['middleware' => 'seller.mid'], function () use ($router) {

            $router->post('book/create', 'BookController@create');
            $router->put('books/update/{id}', 'BookController@update');
            $router->delete('books/delete/{id}', 'BookController@delete');
            $router->get('my-books', 'BookController@showMyBook');
        });


        $router->get('books/{id}', 'BookController@showOneBook');
        $router->get('book-search', 'BookController@searchBook');


        // Categories
        $router->get('index-category', 'CategoriesController@index');
        $router->post('categories-create', 'CategoriesController@create');
        $router->get('categories', 'CategoriesController@showAllCategories');
        $router->get('categories/{id}', 'CategoriesController@showOneCategory');
        $router->put('categories/{id}', 'CategoriesController@update');
        $router->delete('categories/delete/{id}', 'CategoriesController@delete');


        //Authors
        $router->get('index-author', 'AuthorsController@index');
        $router->post('authors-create', 'AuthorsController@create');
        $router->get('authors', 'AuthorsController@showAllAuthors');
        $router->get('authors/{id}', 'AuthorsController@showOneAuhor');
        $router->put('authors/{id}', 'AuthorsController@update');
        $router->delete('authors/delete/{id}', 'AuthorsController@delete');


        //Stripe
        $router->group(['middleware' => 'buyer.mid'], function () use ($router) {

            $router->post('payment', 'StripeController@payStripe');
            $router->get('my-transaction', 'StripeController@myTransaction');
            $router->get('transaction-search', 'StripeController@searchTransaction');

            //Order
            $router->post('order/create/{id}', 'OrdersController@create');
            $router->post('order/pay/{id}', 'OrdersController@oneOrder');
            $router->put('update/order/{id}', 'OrdersController@updateOrder');
            $router->get('my-orders', 'OrdersController@showMyOrders');
            $router->delete('orders/delete/{id}', 'OrdersController@delete');
        });

    });
});
