<?php 

class MostrarPaciente extends TwigView{
	public function show($paciente) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Información del paciente'));
        echo self::getTwig()->render('header.twig.html', array('administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));      
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'mostrarPaciente'), 'paciente' => $paciente);
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>