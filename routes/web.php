<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/vehicles/{modelYear}/{manufacturer}/{model}', 'AppController@getByModelYearMakeModel');

$router->post('/vehicles', 'AppController@getByModelYearMakeModelAsPost');