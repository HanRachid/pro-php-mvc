<?php

use Framework\Routing\Router;

return function (Router $router) {
    $throwException = function () {
        throw new Exception();
    };

    $router->add(
        'GET',
        '/',
        fn () => 'hello world',
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
        fn () => $router->dispatchNotAllowed(),
    );
};
