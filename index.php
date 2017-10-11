<?php
#Mostrar errores:
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
#Notificar todos los errores de PHP:
error_reporting(-1);


require_once('controller/ResourceController.php');
require_once('model/PDORepository.php');
require_once('model/ResourceRepository.php');
require_once('model/Resource.php');
require_once('view/TwigView.php');
require_once('view/SimpleResourceList.php');
require_once('view/Home.php');
require_once('view/Login.php');
require_once('view/Admin.php');
require_once('view/Logup.php');



if(isset($_GET["action"]) && $_GET["action"] == 'login'){
    ResourceController::getInstance()->login();
}elseif(isset($_GET["action"]) && $_GET["action"] == 'admin'){
    ResourceController::getInstance()->admin();
}elseif(isset($_GET["action"]) && $_GET["action"] == 'logup'){
	ResourceController::getInstance()->logup();
}else
	ResourceController::getInstance()->home();