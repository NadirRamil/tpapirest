<?php
require_once './libs/Router.php';
require_once './controllers/recitales-api.controller.php';
require_once './controllers/auth-api.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('recitales', 'GET', 'RecitalApiController', 'getRecitales');
$router->addRoute('recitales/:ID', 'GET', 'RecitalApiController', 'getrecitalById');
$router->addRoute('recitales/:ID', 'DELETE', 'RecitalApiController', 'deleteRecital');
$router->addRoute('recitales', 'POST', 'RecitalApiController', 'insertRecital'); 
$router->addRoute('recitales/:ID', 'PUT','RecitalApiController','updateRecital');

//TOKEN
$router->addRoute("auth/token", 'GET','AuthApiController','getToken');
// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);