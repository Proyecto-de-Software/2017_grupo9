<?php

/**
 * Description of SimpleResourceList
 *
 */


class Home extends TwigView {
    public function show($datos) {
        if(isset($_SESSION['usuario']))
            $iniciar_sesion = 0;
        else
            $iniciar_sesion = 1;

        echo self::getTwig()->render('head.twig.html',  array('title' => 'Hospital Gutierrez'));
        echo self::getTwig()->render('header.twig.html', array('titulo'=>$datos['titulo'],'iniciar_sesion' => $iniciar_sesion , 'usuario' => unserialize($_SESSION['usuario']) , 'administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'index', 'datos'=> $datos));
        echo self::getTwig()->render('footer.twig.html', array('contacto' => $datos['contacto']));	        
        
    }
    
}