<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Controller/Controller.php');
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
            if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_new')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])){
                  $paciente = $this->crear();
                  $validacion = RepositorioPaciente::getInstance()->esValido($paciente);
                  if ($validacion['ok']){
                        if(RepositorioPaciente::getInstance()->agregar($paciente)){
                              $id = $paciente->getId();
                              header("location: /index.php/paciente/$id");
                        }
                        else{
                              header("location: /index.php/pacientes/nuevo");
                        }
                  } else{                             
                        $this->formulario($validacion);
                  }
                        
            } else {
                  header("Location: /index.php");
            }
      }


      public function modificar($id){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_update')){
                  $paciente = crear();
                  $paciente->setId($id);
                  $validacion = RepositorioPaciente::getInstance()->esValido($paciente,true);
                  $id = $paciente->getId();
                  if($validacion['ok']){
                        if(RepositorioPaciente::getInstance()->modificar($paciente)){
                              header("location: /index.php/paciente/$id");
                        }
                  }
                  else {
                        $this->formulario($paciente,$validacion);
                  }
            } else {
                  header("Location: /index.php");
            }
      }

      public function mostrar($id){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_show')){
                  $paciente = RepositorioPaciente::getInstance()->buscarPorId($id);
                  $template = 'administracionMostrarPaciente.twig';
                  $parametrosTemplate = $this->tiposDeDatosDeUnPaciente($paciente);
                  $parametrosTemplate['paciente'] = $paciente;
                  $this->render($template,$parametrosTemplate);
            } else {
                  header("Location: /index.php");
            }
      } 

      public function eliminar($id){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_destroy')){
                  if(RepositorioPaciente::getInstance()->eliminar($id)){
                        header("location: /index.php/pacientes");
                  }
            } else {
                  header("Location: /index.php");
            }
      } 

      public function listarTodos($busquedaNombre=null,$busquedaApellido=null,$busquedaTipoDoc=null,$busquedaNroDoc=null){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_index')){
                  $paginado = datosDePaginado();
                  $template = 'administracionPacientes.twig';
                  $parametrosTemplate['lista'] = RepositorioPaciente::getInstance()->devolverTodos($paginado['limit'],$paginado['cantidadPorPagina'],$busquedaNombre,$busquedaApellido,$busquedaTipoDoc);
                  $parametrosTemplate['paginado'] = $paginado;
                  $this->render($template,$parametrosTemplate);
            } else {
                  header("Location: /index.php");
            }
      }

      public function formulario($idPaciente=null, $validacion=null){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_new') && RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'],'paciente_update')){

                  $template = 'administracionFormularioPaciente.twig';
                  $parametrosTemplate = $this->tiposDeDatos();
                  $parametrosTemplate['validacion'] = $validacion;
                  $parametrosTemplate['paciente'] = RepositorioPaciente::getInstance()->buscarPorId($idPaciente);
                  $this->render($template,$parametrosTemplate);
            } else {
                  header("Location: /index.php");
            }
      }

      public function busqueda($nombre=null,$apellido=null,$tipoDoc=null,$nroDoc=null){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_index')){
                  $this->listarTodos($nombre,$apellido,$tipoDoc,$nroDoc);
            } else {
                  header("Location: /index.php");
            }
      }

      public function tiposDeDatos(){
            $datos['obrasSociales'] = RepositorioPaciente::getInstance()->devolverObrasSociales();
            $datos['tiposDeDocumento'] = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
            return $datos;
      }

      public function tiposDeDatosDatosDeUnPaciente($paciente){
            $datos['obraSocial'] = RepositorioPaciente::getInstance()->devolverObraSocialPorId($paciente->getIdObraSocial());
            $datos['$tipoDeDocumento'] = RepositorioPaciente::getInstance()->devolverTipoDeDocumentoPorId($paciente->getIdTipoDocumento());
            return $datos;
      }
}

?>