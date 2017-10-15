<?php 

class ModificarUsuario extends TwigView{
	public function show($usuario,$mensaje) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Editar usuario'));
        echo self::getTwig()->render('header.twig.html', array('roles' => $_SESSION['roles']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'formularioModificarUsuario', 'usuario' => $usuario, 'mensaje' => $mensaje));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>