<?php
require_once('config/config.php');
require_once('config/autoload.php');

$request = Utils::request("route",'/');

try {
   Utils::handleRoute($request);
} catch (\Throwable $th) {
    $view = new View("404 Error");
    $view->render("/404",['error' =>$th->getMessage()]);
}
