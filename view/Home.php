<?php

/**
 * Description of SimpleResourceList
 *
 * @author fede
 */


class Home extends TwigView {
    
    public function show() {
        
        echo self::getTwig()->render('head.twig.html');
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'index'));
        echo self::getTwig()->render('footer.twig.html');	        
        
    }
    
}
