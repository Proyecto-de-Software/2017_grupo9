<?php

class Logup extends TwigView{
	public function show() {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Registrar'));
        echo self::getTwig()->render('header.twig.html', array('rol' => 'admin'));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'logup'));
        echo self::getTwig()->render('footer.twig.html');
      }
}

?>