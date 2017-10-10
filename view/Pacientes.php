<?php 

class Pacientes extends TwigView{
	public function show() {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Administracion de pacientes'));
        echo self::getTwig()->render('header.twig.html', array('rol' => $_SESSION['roles']));        
        echo self::getTwig()->render('conteiner.twig.html', array('tipo' => 'pacientes'));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>