<?php 

class Config extends TwigView{
	public function show() {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Configuración'));
        echo self::getTwig()->render('header.twig.html', array('rol' => 'admin'));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'config'));
        echo self::getTwig()->render('footer.twig.html');
      }
}

?>