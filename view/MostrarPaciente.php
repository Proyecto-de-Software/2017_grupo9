<?php 

class MostrarPaciente extends TwigView{
	public function show($paciente) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Información del paciente'));
        echo self::getTwig()->render('header.twig.html', array('rol' => $_SESSION['roles']), 'paciente' => $paciente);        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'mostrarPaciente'));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>