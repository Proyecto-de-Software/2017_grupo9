<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


require_once('view/TwigView.php');
require_once('view/Inicio.php');


if(isset($_GET["action"]) && $_GET["action"] == 'listResources'){
    ResourceController::getInstance()->listResources();
}else{
    ResourceController::getInstance()->home();
}

