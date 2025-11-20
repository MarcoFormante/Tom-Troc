<?php

spl_autoload_register(function($classname){
    //controllers
    if (file_exists("../controllers/$classname.php")){
        require_once "../controllers/$classname.php";
    }

    //models
    if (file_exists("../models/$classname.php")){
        require_once "../models/$classname.php";
    }

    //views
    if (file_exists("../views/$classname.php")){
        require_once "../views/$classname.php";
    }

    //services
    if (file_exists("../services/$classname.php")){
        require_once "../services/$classname.php";
    }

    //fixtures
    if (file_exists("../fixtures/$classname.php")){
        require_once "../fixtures/$classname.php";
    }
});
   
