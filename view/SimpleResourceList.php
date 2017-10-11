<?php

/**
 * Description of SimpleResourceList
 *
 */

class SimpleResourceList extends TwigView {
    
    public function show($resourceArray) {
        
        echo self::getTwig()->render('listResources.html.twig', array('resources' => $resourceArray));
        
        
    }
    
}