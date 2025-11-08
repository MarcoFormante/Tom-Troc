<?php
require_once('config/config.php');
require_once('config/autoload.php');


$db = new DBManager();

$users = $db->query("SELECT * FROM users");

$view = new View("home");

$view->render('home',["title2" => "ciao"]);