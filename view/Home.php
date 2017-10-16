<?php

/**
 * Description of SimpleResourceList
 *
 */


class Home extends TwigView {
    
    public function show() {
        $es_administrador=0;
        $es_recepcionista=0;
        $es_pediatra=0;
        if(isset($_SESSION['usuario'])){
        	$parametro = unserialize($_SESSION['usuario']);
            foreach($parametro->getRoles() as $rol){
                switch ($rol['nombre']) {
                    case 'administrador':
                        $es_administrador=1;
                        break;
                    case 'recepcionista':
                        $es_recepcionista=1;
                        break;
                    case 'pediatra':
                        $es_pediatra=1;
                        break;
                }
            }      
        } else {
            $parametro = "home";
        }

        
        echo self::getTwig()->render('head.twig.html',  array('title' => 'Hospital Gutierrez'));
        echo self::getTwig()->render('header.twig.html', array('parametro' => $parametro , 'administrador' => $es_administrador , 'recepcionista' => $es_recepcionista , 'pediatra' => $es_pediatra));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'index'));
        echo self::getTwig()->render('footer.twig.html');	        
        
    }
    
}