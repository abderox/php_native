<?php

use BuildingWebSite\BuildingWebSite;
use Route\Request;
use Router\Router;
use Security\SecurityController;

include_once './App/Route/Router.php';
include_once './App/Vendor/Route_/Request.php';
include_once './App/Controller/BuildingWebSite.php';
include_once './App/Controller/SecurityController.php';
$router = new Router(new Request);

$router->get('/', function() {
    return <<<HTML
  <h1>Hello world</h1>
HTML;
});


$router->get('/profile', function($request) {
    return <<<HTML
  <h1>Profile</h1>
HTML;
});

$router->post('/data', function($request) {

    return json_encode($request->getBody());
});

$router->get('/index', BuildingWebSite::index());

$router->get('/signup', SecurityController::signup());

$router->get('/postsignup', SecurityController::postSignup());