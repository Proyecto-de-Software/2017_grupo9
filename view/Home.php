<?php

/**
 * Description of SimpleResourceList
 *
 */


class Home extends TwigView {
    
    public function show() {
        if(isset($_SESSION['usuario'])){
        	$parametro = $_SESSION['usuario'];
        }
        else $parametro = "home";
        
        echo self::getTwig()->render('head.twig.html',  array('title' => 'Hospital Gutierrez'));
        echo self::getTwig()->render('header.twig.html', array('parametro' => $parametro));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'index'));
        echo self::getTwig()->render('footer.twig.html');	        
        
    }
    
}