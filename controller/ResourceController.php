<?php

/**
 * Description of ResourceController
 *
 * @author fede
 */
class ResourceController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    
    public function listResources(){
        $resources = ResourceRepository::getInstance()->listAll();
        $view = new SimpleResourceList();
        $view->show($resources);
    }
    
    public function home(){
        $view = new Home();
        $view->show();
    }
    
    public function login(){
        $view = new Login();
        $view->show();
    }

    public function admin(){
        $view = new Admin();
        $view->show();
    }

    public function logup(){
        $view = new Logup();
        $view->show();
    }
}
