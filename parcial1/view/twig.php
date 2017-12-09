<?php

require_once '../vendor/autoload.php';

Class Twig {

	protected static $twig;

	public function getTwig(){
		if(!isset(self::$twig)) {
			$loader = new Twig_Loader_Filesystem('./view');
			self::$twig = new Twig_Environment($loader, array('cache' => './cache',));
		}
		return self::$twig;
	}

}

?>