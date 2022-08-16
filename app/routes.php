<?php

use Framework\Routing\Router;
use Framework\View\View;

return function (Router $router) {
    $throwException = function () {
        throw new Exception();
    };

    $router->add(
        'GET',
        '/',
        fn () => View::make('home', ['number' => 56]),
    );

    $router->add(
        'GET',
        '/old-home',
        fn () => $router->redirect('/'),
    );

    $router->add(
        'GET',
        '/has-server-error',
        fn () => $throwException,
    );

    $router->add(
        'GET',
        '/has-validation-error',
        fn () => $router->dispatchNotAllowed()
    );

    $router->errorHandler(
        404,
        fn () => '404 not found baby'
    );
    $router->add(
        'GET',
        '/products/view/{product}',
        function () use ($router) {
            $parameters = $router->current()->parameters();


            return View::view('products/view', [
        'product' => $parameters['product'],
        'scary' => '<script>console.log("u been hacked laule")</script>',
        ]);
        },
    );


    $router->add(
        'GET',
        '/products/view/',
        function () {
            return "select product";
        },
    );



    $router->add(
        'GET',
        '/products/{page?}',
        function () use ($router) {
            $parameters = $router->current()->parameters();

            $parameters['page'] ??= 1;

            if (is_numeric($parameters['page'])) {
                $next = $router->route(
                    'product-list',
                    ['page' => $parameters['page'] + 1]
                );

                return "products for page {$parameters['page']}, next page is {$next}";
            } else {
                return "Please use numbers in the URL after";
            }
        },
    )->name("product-list");

    $router->add(
        'GET',
        '/services/view/{service?}',
        function () use ($router) {
            $parameters = $router->current()->parameters();

            if (empty($parameters['service'])) {
                return 'all services';
            }

            return "service is {$parameters['service']}";
        },
    );
};
