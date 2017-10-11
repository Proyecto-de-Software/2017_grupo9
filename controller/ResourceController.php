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
        require_once("../view/Home.php");
        $view = new Home();
        $view->show();
    }
    
    public function login(){
        require_once("../view/Login.php");
        $view = new Login();
        $view->show();
    }

    public function admin(){
        $view = new Admin();
        $view->show();
    }

    public function logup(){
        require_once("../view/Logup.php");
        $view = new Logup();
        $view->show();
    }

    public function listarPacientes($pacientes){
        require_once("../view/ListarPacientes.php");
        $view = new ListarPacientes();
        $view->show($pacientes);
    }

    public function mostrarPaciente(){
        require_once("../view/MostrarPacientes.php");
        $view = new MostrarPaciente();
        $view->show();
    }

    public function agregarPaciente(){
        require_once("../view/AgregarPacientes.php");
        $view = new AgregarPacientes();
        $view->show();
    }

    public function modificarPaciente(){
        require_once("./view/ModificarPaciente.php");
        $view = new ModificarPaciente();
        $view->show();
    } 
}
