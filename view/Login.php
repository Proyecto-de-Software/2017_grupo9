<?php

class Login extends TwigView{
	public function show() {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Iniciar sesion'));
        echo self::getTwig()->render('header.twig.html', array('rol' => 'basico'));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'login'));
        echo self::getTwig()->render('footer.twig.html');
      }
}

?>