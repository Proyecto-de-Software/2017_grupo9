<?php

	class Controller {

		protected static $instance;

		public static function getInstance() {
			if(!isset(self::$instance)) {
				self::$instance = new Controller();
			}
			return self::$instance;
		}

		public function formularioLogin() {
			Twig::getTwig()->render('formularioLogin.html', array());
		}

		public function home() {
			Twig::getTwig()->render('home.html', array('usuario' => 'puto'));
		}






	}



	//echo $twig->render('login.html', array());
























?>