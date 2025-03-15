<?php
require_once(__DIR__ . "/routes/Router.php");

use Routes\Router;

$router = new Router();
$router->run();
