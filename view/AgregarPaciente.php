<?php 

class AgregarPaciente extends TwigView{
	public function show($obrasSociales,$tiposDeDocumento) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Agregar paciente'));
        echo self::getTwig()->render('header.twig.html', array('roles' => $_SESSION['roles']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'agregarPaciente', 'tiposDeDocumento' => $tiposDeDocumento, 'obrasSociales' => $obrasSociales));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>