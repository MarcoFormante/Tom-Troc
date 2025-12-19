<?php

ini_set('display_errors', '0');

require_once('../config/config.php');
require_once('../config/autoload.php');

$request = Utils::request("route",'/');

try {
   Router::handleRoute($request);

}catch (Throwable $th) {
    $_SESSION["catched"] = $th;
    Utils::redirect("index.php?route=/error");
}
