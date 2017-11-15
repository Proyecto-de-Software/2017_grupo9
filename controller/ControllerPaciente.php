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

      public function formularioPaciente($paciente=null, $validacion=null){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_new') && RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'],'paciente_update')){

                  $template = 'administracionModificarPaciente.twig';
                  $parametrosTemplate['validacion'] = $validacion;
                  $parametrosTemplate['paciente'] = $paciente;
                  $parametrosTemplate['obrasSociales'] = RepositorioPaciente::getInstance()->devolverObrasSociales();
                  $parametrosTemplate['$tiposDeDocumento'] = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
                  $this->render($template,$parametrosTemplate);
            } else {
                  header("Location: ./index.php");
            }
      }

      public function agregar(){
            if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_new')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])){
                  $paciente = $this->crear();
                  $validacion = RepositorioPaciente::getInstance()->pacienteValido($paciente);
                  if ($validacion['ok']){
                        if(RepositorioPaciente::getInstance()->agregar($paciente)){
                              $id = $paciente->getId();
                              header("location: ./index.php/paciente/$id");
                        }
                        else{
                              header("location: ./index.php/pacientes/nuevo");
                        }
                  } else{                             
                        $this->formularioPaciente($validacion);
                  }
                        
            } else {
                  header("Location: ./index.php");
            }
      }


      public function modificar($id){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_update')){
                  $paciente = crear();
                  $paciente->setId($id);
                  $validacion = RepositorioPaciente::getInstance()->pacienteValido($paciente,true);
                  $id = $paciente->getId();
                  if($validacion['ok']){
                        if(RepositorioPaciente::getInstance()->modificar($paciente)){
                              header("location: ./index.php/paciente/$id");
                        }
                  }
                  else {
                        $this->formularioPaciente($paciente,$validacion);
                  }
            } else {
                  header("Location: ./index.php");
            }
      }

      public function mostrar($id){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_show')){
                  $paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_GET['id']);
                  $template = 'administracionMostrarPaciente.twig';
                  $parametrosTemplate['paciente'] = $paciente;
                  $parametrosTemplate['obraSocial'] = RepositorioPaciente::getInstance()->devolverObraSocialPorId($paciente->getIdObraSocial());
                  $parametrosTemplate['$tipoDeDocumento'] = RepositorioPaciente::getInstance()->devolverTipoDeDocumentoPorId($paciente->getIdTipoDocumento());
                  $this->render($template,$parametrosTemplate);
            } else {
                  header("Location: ./index.php");
            }
      } 

      public function eliminar($id){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_destroy')){
                  if(RepositorioPaciente::getInstance()->eliminar($id)){
                        header("location: ./index.php/pacientes");
                  }
            } else {
                  header("Location: ./index.php");
            }
      } 

      public function listarTodos($busquedaNombre=null,$busquedaApellido=null,$busquedaTipoDoc=null,$busquedaNroDoc=null){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_index')){
                  $paginado = datosDePaginado();
                  $template = 'administracionPacientes.twig';
                  $parametrosTemplate['lista'] = RepositorioPaciente::getInstance()->devolverPacientes($paginado['limit'],$paginado['cantidadPorPagina'],$busquedaNombre,$busquedaApellido,$busquedaTipoDoc);
                  $parametrosTemplate['paginado'] = $paginado;
                  $this->render($template,$parametrosTemplate);
            } else {
                  header("Location: ./index.php");
            }
      }

      public function busqueda($nombre=null,$apellido=null,$tipoDoc=null,$nroDoc=null){
            if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_index')){
                  $this->listarTodos($nombre,$apellido,$tipoDoc,$nroDoc);
            } else {
                  header("Location: ./index.php");
            }
      }
}

?>