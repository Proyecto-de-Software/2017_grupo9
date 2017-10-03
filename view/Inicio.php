<?php

/**
 * Description of SimpleResourceList
 *
 * @author fede
 */


class Inicio extends TwigView {
    
    public function show() {
        
        echo self::getTwig()->render('head.html.twig');
        echo self::getTwig()->render('container.html.twig','index');
        echo self::getTwig()->render('footer.html.twig');        
        
    }
    
}
