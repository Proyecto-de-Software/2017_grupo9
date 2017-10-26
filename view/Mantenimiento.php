<?php

class Mantenimiento extends TwigView{
	public function show($contacto,$titulo) {
		echo self::getTwig()->render('header.twig.html', array('mantenimiento' => true));
		 echo self::getTwig()->render('head.twig.html',  array('titulo'=>$titulo,'title' => 'Sitio en mantenimiento'));
	    echo self::getTwig()->render('mantenimiento.twig.html');
        echo self::getTwig()->render('footer.twig.html',array('contacto' => $contacto));
      }
}

?>