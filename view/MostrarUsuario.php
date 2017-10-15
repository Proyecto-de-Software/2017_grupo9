<?php 

class MostrarUsuario extends TwigView{
	public function show($usuario) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Información del usuario'));
        echo self::getTwig()->render('header.twig.html', array('roles' => $_SESSION['roles']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'mostrarUsuario', 'usuario' => $usuario));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>