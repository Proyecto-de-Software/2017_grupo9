<?php 

class ModificarPaciente extends TwigView{
	public function show($paciente,$obrasSociales,$tiposDeDocumento) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Editar paciente'));
        echo self::getTwig()->render('header.twig.html', array('roles' => $_SESSION['roles']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'formularioModificarPaciente', 'paciente' => $paciente, 'tiposDeDocumento' => $tiposDeDocumento, 'obrasSociales' => $obrasSociales));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>