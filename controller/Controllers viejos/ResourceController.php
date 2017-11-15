<?php
chdir($_SERVER['DOCUMENT_ROOT']);
require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioConfiguracion.php");
require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseConfiguracion.php");
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
        require_once($_SERVER['DOCUMENT_ROOT']."/view/Home.php");
        $config = RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion();
        $datosConfigurados =array(
            'hospital' => $config->getDescripcionHospital(),
            'guardia' => $config->getDescripcionGuardia(),
            'especialidades' => $config->getDescripcionEspecialidades(),
            'titulo' => $config->getTitulo(),
            'contacto' => $config->getContacto()
        );
        $view = new Home();
        $view->show($datosConfigurados);
    }

    public function admin(){
        $view = new Admin();
        $view->show();
    }

    public function logup(){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/Logup.php");
        $view = new Logup();
        $view->show();
    }

    public function listarPacientes($pacientes){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/ListarPacientes.php");
        $view = new ListarPacientes();
        $view->show($pacientes);
    }

    public function mostrarPaciente(){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/MostrarPacientes.php");
        $view = new MostrarPaciente();
        $view->show();
    }

    public function agregarPaciente(){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/AgregarPacientes.php");
        $view = new AgregarPacientes();
        $view->show();
    }

    public function modificarPaciente(){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/ModificarPaciente.php");
        $view = new ModificarPaciente();
        $view->show();
    }
}
