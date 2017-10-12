<?php
#Mostrar errores:
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
#Notificar todos los errores de PHP:
error_reporting(-1);

require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ResourceController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/PDORepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ResourceRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/Resource.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/SimpleResourceList.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/Home.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/Login.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/Admin.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/Logup.php');



if(isset($_GET["action"]) && $_GET["action"] == 'login'){
    ResourceController::getInstance()->login();
}elseif(isset($_GET["action"]) && $_GET["action"] == 'admin'){
    ResourceController::getInstance()->admin();
}elseif(isset($_GET["action"]) && $_GET["action"] == 'logup'){
	ResourceController::getInstance()->logup();
}else
	ResourceController::getInstance()->home();