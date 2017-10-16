<?php 

class MostrarUsuario extends TwigView{
	public function show($usuario) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Información del usuario'));
        echo self::getTwig()->render('header.twig.html', array('usuario' => unserialize($_SESSION['usuario']) , 'administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));       
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'mostrarUsuario', 'usuario' => $usuario));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>