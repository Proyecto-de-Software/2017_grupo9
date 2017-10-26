<?php 

class AgregarPaciente extends TwigView{
	public function show($obrasSociales,$tiposDeDocumento,$datos) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Agregar paciente'));
        echo self::getTwig()->render('header.twig.html', array('usuario' => unserialize($_SESSION['usuario']) , 'administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'agregarPaciente', 'tiposDeDocumento' => $tiposDeDocumento, 'obrasSociales' => $obrasSociales));
        echo self::getTwig()->render('footer.twig.html',array('contacto'=>$datos['contacto']));
    }
}

?>