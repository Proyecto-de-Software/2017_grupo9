<?php

/**
 * Description of SimpleResourceList
 *
 */


class Home extends TwigView {
    public function show() {
        if(isset($_SESSION['usuario']))
            $iniciar_sesion = 0;
        else
            $iniciar_sesion = 1;
        echo self::getTwig()->render('head.twig.html',  array('title' => 'Hospital Gutierrez'));
        echo self::getTwig()->render('header.twig.html', array('iniciar_sesion' => $iniciar_sesion , 'administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'index'));
        echo self::getTwig()->render('footer.twig.html');	        
        
    }
    
}