<?php 

class AgregarUsuario extends TwigView{
	public function show() {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Agregar usuario'));
        echo self::getTwig()->render('header.twig.html', array('roles' => $_SESSION['roles']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'agregarUsuario'));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>