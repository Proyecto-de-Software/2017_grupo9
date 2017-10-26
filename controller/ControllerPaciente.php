<?php
	
	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);

	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClasePaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioConfiguracion.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioRol.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPermiso.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/view/TwigView.php");

	if(!isset($_SESSION))
		session_start();

	function obtenerConfiguracion(){
    	require_once($_SERVER['DOCUMENT_ROOT']."/view/Home.php");
    	$config = RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion();
    	$datosConfigurados =array(
    		'habilitao' => $config->getHabilitado(),
            'hospital' => $config->getDescripcionHospital(),
            'guardia' => $config->getDescripcionGuardia(),
            'especialidades' => $config->getDescripcionEspecialidades(),
            'contacto' => $config->getContacto()
        );
        return $datosConfigurados;
    }
    $config = obtenerConfiguracion();
	if(!$config['habilitado']){
	    header("Location: /../");
	}
	function crearPaciente(){
		$paciente = new Paciente($_POST['apellido'], $_POST['nombre'], $_POST['domicilio'], $_POST['telefono'], $_POST['fechaNacimiento'], $_POST['genero'], $_POST['idObraSocial'], $_POST['idTipoDocumento'], $_POST['numeroDoc']);
		return $paciente;
	}

	function listarPacientes(){
	    require_once($_SERVER['DOCUMENT_ROOT']."/view/ListarPacientes.php");
	    $view = new ListarPacientes();
	    $view->show(RepositorioPaciente::getInstance()->devolverPacientes(),obtenerConfiguracion());
   	}

    function mostrarPaciente($paciente,$obraSocial,$tipoDeDocumento){
	    require_once($_SERVER['DOCUMENT_ROOT']."/view/MostrarPaciente.php");
	    $view = new MostrarPaciente();
	    $view->show($paciente,$obraSocial,$tipoDeDocumento,obtenerConfiguracion());
    }

    function agregarPaciente($obrasSociales,$tiposDeDocumento){
	    require_once($_SERVER['DOCUMENT_ROOT']."/view/AgregarPaciente.php");
	    $view = new AgregarPaciente();
	    $view->show($obrasSociales,$tiposDeDocumento,obtenerConfiguracion());
    }

    function modificarPaciente($paciente, $obrasSociales, $tiposDeDocumento){
	    require_once($_SERVER['DOCUMENT_ROOT']."/view/FormularioModificarPaciente.php");
	    $view = new ModificarPaciente();
	    $view->show($paciente,$obrasSociales,$tiposDeDocumentoobtenerConfiguracion());
    } 

	if(isset($_GET['action'])){
		switch ($_GET['action']) {
			case 'altaDePaciente':
				//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
				if(RepositorioPermiso::getInstance()->UsuarioTienePermiso(unserialize($_SESSION['usuario']), 'paciente_new')){
					$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    		$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
		       		agregarPaciente($obrasSociales,$tiposDeDocumento);
		       	} else {
	    			header("Location: /../");
	    		}
		       	//	}
		       	break;
		    case 'agregarPaciente':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		    	if(RepositorioPermiso::getInstance()->UsuarioTienePermiso(unserialize($_SESSION['usuario']), 'paciente_new')){
		    		$paciente = crearPaciente();
		    		$obraSocial = RepositorioPaciente::getInstance()->devolverObrasSociales($paciente->getIdObraSocial());
		    		$tipoDeDocumento = RepositorioPaciente::getInstance()->devolverTipoDeDocumentoPorId($paciente->getIdTipoDocumento());

        			if(RepositorioPaciente::getInstance()->agregarPaciente($paciente)){
		       			mostrarPaciente($paciente,$obraSocial,$tipoDeDocumento);
		       		}
		       		else{
						$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    			$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
		       			agregarPaciente($obrasSociales,$tiposDeDocumento);
		       		}
		       	} else {
	    			header("Location: /../");
	    		}
		       //	}
		        break;
		    case 'modificacionDePaciente':
		    	if(RepositorioPermiso::getInstance()->UsuarioTienePermiso(unserialize($_SESSION['usuario']), 'paciente_update')){
			    	$paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_GET['id']);
			    	$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
			    	$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
			    	modificarPaciente($paciente, $obrasSociales, $tiposDeDocumento);
			    } else {
	    			header("Location: /../");
	    		}
		    	break;
		    case 'modificarPaciente':
		    //	if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		    	if(RepositorioPermiso::getInstance()->UsuarioTienePermiso(unserialize($_SESSION['usuario']), 'paciente_update')){
		        	RepositorioPaciente::getInstance()->modificarPaciente(crearPaciente());
		        	mostrarPaciente(RepositorioPaciente::getInstance()->buscarPacientePorId($_POST['id']));
		        } else {
	        		header("Location: /../");
    			}
		       // }
		        break;
		    case 'eliminarPaciente':
		    	//if(($_SESSION['usuario'])->esAdministrador()){
		   		if(RepositorioPermiso::getInstance()->UsuarioTienePermiso(unserialize($_SESSION['usuario']), 'paciente_destroy')){
		        	if(RepositorioPaciente::getInstance()->eliminarPaciente($_GET['id'])){
		        		listarPacientes();
		        	}
		        } else {
	        		header("Location: /../");
    			}
		       // }
		        break;
		    case 'mostrarPaciente':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		    	if(RepositorioPermiso::getInstance()->UsuarioTienePermiso(unserialize($_SESSION['usuario']), 'paciente_show')){
		    		$paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_POST['id']);
		        	mostrarPaciente($paciente);
		        } else {
	        		header("Location: /../");
    			}
		       // }
		        break;
		    case 'listarPacientes':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista() || ($_SESSION['usuario'])->esAdministrador()){
		    	if(RepositorioPermiso::getInstance()->UsuarioTienePermiso(unserialize($_SESSION['usuario']), 'paciente_index')){
		    		$pacientes = RepositorioPaciente::getInstance()->devolverPacientes();
		        	listarPacientes($pacientes);
		        } else {
	        		header("Location: /../");
    			}
		       // }
		        break;
		}
	}	

