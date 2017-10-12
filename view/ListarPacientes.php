<?php 

require_once("TwigView.php");

class ListarPacientes extends TwigView{
	public function show($pacientes) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Administracion de pacientes'));
        echo self::getTwig()->render('header.twig.html', array('roles' => $_SESSION['roles']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'listarPacientes','lista' => $pacientes,'titulo'=>'Pacientes'));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>