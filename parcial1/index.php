<?php

require_once('./view/twig.php');
require_once('./controller/controller.php');


if($action = isset($_GET['action'])) {
	switch($action) {
		case "login":
			Controller::getInstance()->formularioLogin();
			break;
		case "puto":
			//algo
			break;
	}
} else {
	Controller::getInstance()->home();
}