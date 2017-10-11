<?php 

class ModificarPaciente extends TwigView{
	public function show($paciente) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Información del paciente'));
        echo self::getTwig()->render('header.twig.html', array('roles' => $_SESSION['roles']), 'paciente' => $paciente);        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'modificarPaciente'));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>