<?php 

class ModificarUsuario extends TwigView{
	public function show($usuario,$mensaje,$roles) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Editar usuario'));
        echo self::getTwig()->render('header.twig.html', array('administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'formularioModificarUsuario', 'usuario' => $usuario, 'mensaje' => $mensaje,'roles' => $roles));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>