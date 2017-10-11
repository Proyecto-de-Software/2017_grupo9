<?php

/**
 * Description of ResourceController
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

    public function pacientes(){
        $view = new Pacientes();
        $view->show();
    }

    public function mostrarPaciente(){
        $view = new Paciente();
        $view->show();
    }

    public function agregarPaciente(){
        $view = new AgregarPacientes();
        $view->show();
    }    
}
