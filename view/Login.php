<?php

class Login extends TwigView{
	public function show($e) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Iniciar sesion'));
        echo self::getTwig()->render('header.twig.html', array('administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'login','mensaje'=> $e));
        echo self::getTwig()->render('footer.twig.html');
      }
}

?>