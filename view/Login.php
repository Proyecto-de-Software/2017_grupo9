<?php

class Login extends TwigView{
	public function show($e,$datosConfigurados) {

	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Iniciar sesion'));
        echo self::getTwig()->render('header.twig.html', array('titulo'=>$datosConfigurados['titulo'],'usuario' => unserialize($_SESSION['usuario']) , 'administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'login','mensaje'=> $e));
        echo self::getTwig()->render('footer.twig.html', array('contacto' => $datosConfigurados['contacto']));
      }
}

?>