<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php');
class ControllerSeguridad extends Controller{
     protected static $instance;
	public static function getInstance() {

      	if (!isset(self::$instance)) {
          self::$instance = new ControllerSeguridad();
      	}
      	return self::$instance;
    }  
    public function sec_session_start() {
        //$session_name = 'sec_session_id';   // Configura un nombre de sesión personalizado.
        $secure = false;
        // Esto detiene que JavaScript sea capaz de acceder a la identificación de la sesión.
        $httponly = true;
        /*
        // Obliga a las sesiones a solo utilizar cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }
        */
        // Obtiene los params de los cookies actuales.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"],
            $cookieParams["path"], 
            $cookieParams["domain"], 
            $secure,
            $httponly);
        // Configura el nombre de sesión al configurado arriba.
        //session_name($session_name);
        session_start();            // Inicia la sesión PHP.
        session_regenerate_id();    // Regenera la sesión, borra la previa. 
    } 
}

?>