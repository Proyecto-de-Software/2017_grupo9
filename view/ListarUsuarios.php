<?php 

require_once("TwigView.php");

class ListarUsuarios extends TwigView{
	public function show($usuarios,$filtrado,$datos) {

	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Administración de usuarios'));
        echo self::getTwig()->render('header.twig.html', array('titulo'=>$datos['titulo'],'usuario' => unserialize($_SESSION['usuario']) , 'administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'listarUsuarios','lista' => $usuarios, 'titulo'=>'Usuarios','filtrado'=>$filtrado));
        echo self::getTwig()->render('footer.twig.html', array('contacto' => $datos['contacto']));
    }
}
?>