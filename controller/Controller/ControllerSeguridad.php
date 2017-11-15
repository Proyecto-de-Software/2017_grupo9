<?php

class ControllerSeguridad extends Controller{

	public static function getInstance() {
      	if (!isset(self::$instance)) {
          self::$instance = new ControllerSeguridad();
      	}
      	return self::$instance;
      }   
}

?>