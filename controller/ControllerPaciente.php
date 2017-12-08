<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php');
class ControllerPaciente extends Controller{
	protected static $instance;
      public static function getInstance() {
      	if (!isset(self::$instance)) {
                  self::$instance = new ControllerPaciente();
      	}
      	return self::$instance;
      }  

      public function crear(){
      	//Instancia un objeto de la clase Paciente, con los datos recibidos por POST desde el formulario de alta o edicion de datos del paciente.
      	$paciente = new Paciente($_POST['apellido'], $_POST['nombre'], $_POST['domicilio'], $_POST['telefono'], $_POST['fechaNacimiento'], $_POST['genero'], $_POST['idObraSocial'], $_POST['idTipoDocumento'], $_POST['numeroDoc']);
		return $paciente;
      }

      public function agregar(){

            if($this->hayPermiso('paciente_new') && $this->tokenValido($_POST['token'])){
                  $paciente = $this->crear();
                  $validacion = RepositorioPaciente::getInstance()->esValido($paciente);
                  if ($validacion['ok']){
                        if(RepositorioPaciente::getInstance()->agregar($paciente)){ 
                              $id = $paciente->getId();
                              $this->redireccion("/index.php/paciente/$id");
                        }
                        else{
                              $this->redireccion("/index.php/paciente/nuevo");
                        }
                  } else{                             
                        $this->formulario($validacion);
                  }
                        
            } else {
                  $this->redireccion('/index.php');
            }
      }

      public function formulario($idPaciente=null, $validacion=null, $pacienteInvalido = null){
            if($this->hayPermiso('paciente_new') || $this->hayPermiso('paciente_update')){
                  $template = 'administracionFormularioPaciente.twig';
                  $parametrosTemplate = $this->tiposDeDatos();
                  $parametrosTemplate['validacion'] = $validacion;
                  if($idPaciente != null){
                        $parametrosTemplate['paciente'] = RepositorioPaciente::getInstance()->buscarPorId($idPaciente);
                  }
                  $this->render($template,$parametrosTemplate);
            } else {
                 $this->redireccion('/index.php');
            }
      }

      public function modificar($id){
            if($this->hayPermiso('paciente_update') && $this->tokenValido($_POST['token'])){
                  $paciente = $this->crear();
                  $paciente->setId($id);
                  $validacion = RepositorioPaciente::getInstance()->esValido($paciente,true);
                  $id = $paciente->getId();
                  if($validacion['ok']){
                        if(RepositorioPaciente::getInstance()->modificar($paciente)){
                              $this->redireccion("/index.php/paciente/$id");
                        }
                  }
                  else {
                        $this->formulario($id,$validacion,$paciente);
                  }
            } else {
                  $this->redireccion('/index.php');
            }
      }

      public function mostrar($id){
            if($this->hayPermiso('paciente_show')){
                  $paciente = RepositorioPaciente::getInstance()->buscarPorId($id);
                  $template = 'administracionMostrarPaciente.twig';
                  $parametrosTemplate = $this->tiposDeDatosDatosDeUnPaciente($paciente);
                  $parametrosTemplate['paciente'] = $paciente;
                  $parametrosTemplate['permiso'] = $this->hayPermiso('control_index'); 
                  $this->render($template,$parametrosTemplate);
            } else {
                  $this->redireccion('/index.php');
            }
      } 

      public function eliminar($id){
            if($this->hayPermiso('paciente_destroy')){
                  if(RepositorioPaciente::getInstance()->eliminar($id)){
                        $this->redireccion('/index.php/pacientes');
                  }
            } else {
                  $this->redireccion('/index.php');
            }
      } 

      public function listarTodos($busqueda = null,$pagina = 1,$accion=''){
            if($this->hayPermiso('paciente_index')){
                  $listado = RepositorioPaciente::getInstance()->devolverTodos($busqueda);
                  $paginado = $this->paginar($listado,$pagina);
                  $template = 'administracionPacientes.twig';
                  $parametrosTemplate['tiposDeDocumento'] = $this->datosAPI("tipo-documento");
                  $parametrosTemplate['lista'] = RepositorioPaciente::getInstance()->devolverTodos($busqueda,$paginado['offset'],$paginado['cantidadPorPagina']);
                  $parametrosTemplate['busqueda'] = $busqueda;
                  $parametrosTemplate['action'] = $accion;
                  $parametrosTemplate['tipo'] = 'pacientes';
                  $parametrosTemplate['paginado'] = $paginado;
                  $this->render($template,$parametrosTemplate);
            } else {
                  $this->redireccion('/index.php');
            }
      }
      /*
      Forma de usar la funcion Controller::getInstance()->paginar($listado,$pagina);
            1) se obtiene un listado de la base de datos sin limitar cantidaddes ni paginas. Si filtrando si es necesario depende la busqueda.
            2)Una vez que esta el listado. Se usa la funcion paginar($listado,$pagina); Esta funcion va a devolver un arreglo $paginado, donde estaran todos los datos necesarios para el template de paginacion. El parametro $pagina, se debe verificar en el index, en las acciones /pacientes o /busqueda depende como lo tengas (mira usuarios). Se pregunta si esta seteado GET page, y si esta seteado se usa ese valor, sino se manda 1. Esta funcion listar todos debe recibir un parametro $pagina.
            3)Despues de haber usado la funcion paginar (y guardado en una variable) ej: $paginado = paginar($listado,$pagina), ya se tienen los datos para mandar al template, entonces lo unico que haria falta es mandar dos parametros mas al template.
                  a) parametro que dice el tipo de paginado ('usuarios' o 'pacientes'); Este parametro se debe llamar tipo
                  b) la accion que va despues de pacientes/, en este caso /busquedaDocumento o la otra. Este parametro se debe llamar accion. Este parametro se debe mandar con la /. Y se debe setear por defecto en '', para que cuando se llame sin busqueda, entre a /pacientes y liste. Y cuando se llame con busqueda entre a /pacientes{{accion}}, en este caso accion tendria /busquedaNOmbre o algo asi. 
            Con esto creo que no vas a tener drama, sino mira bien las funciones de usuario. 
            En el repositorio paciente, en la funcion que tengas para devolver pacientes, hay que hacerla mas generica todavia, dando la posibilidad de que offset y cantidad no se manden. Entonces asi se puede usar la paginacion bien, primero pedis los datos sin offset y cantidad, se los mandas al paginar para hacer los calculos, y despues haces la consulta con el offset y cantidad.


      */

      public function obtenerDatosBusquedaNombre(){
            $busqueda = null;
            if(isset($_POST['busquedaNombre']) && trim($_POST['busquedaNombre']) !=''){
                  $busqueda['nombre'] = $_POST['busquedaNombre'];
            }
            if(isset($_POST['busquedaApellido']) && trim($_POST['busquedaApellido']) !=''){
                  $busqueda['apellido'] = $_POST['busquedaApellido'];
            }
            return $busqueda;
      }

      public function obtenerDatosBusquedaDocumento(){
            $busqueda = null;
            if(isset($_POST['busquedaNumeroDoc']) && trim($_POST['busquedaNumeroDoc']) !=''){
                  $busqueda['tipoDoc'] = $_POST['busquedaTipoDoc'];
                  $busqueda['nroDoc'] = $_POST['busquedaNumeroDoc'];
            }
            return $busqueda;
      }

      public function tiposDeDatos(){
            $datos['obrasSociales'] = $this->datosAPI("obra-social");
            $datos['tiposDeDocumento'] = $this->datosAPI("tipo-documento");
            return $datos;
      }

      public function tiposDeDatosDatosDeUnPaciente($paciente){
            $datos['obraSocial'] = $this->datosAPI("obra-social", "/".$paciente->getIdObraSocial());
            $datos['tipoDeDocumento'] = $this->datosAPI("tipo-documento", "/".$paciente->getIdTipoDocumento());
            return $datos;
      }
}

?>