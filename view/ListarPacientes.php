<?php 

//chdir($_SERVER['DOCUMENT_ROOT']);

require_once('TwigView.php');
/*require_once($_SERVER['DOCUMENT_ROOT'].'./controller/ControllerPaciente');

if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'altaDePaciente':
			//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
	       		agregarPaciente();
	       	//	}
	       	break;
	    case 'agregarPaciente':
	    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
	    		$paciente = crearPaciente();
	       		if(RepositorioPaciente::getInstance()->agregarPaciente($paciente)){
	       			mostrarPaciente($paciente);
	       		}
	       		else{
	       			agregarPaciente();
	       		}
	       //	}
	        break;
	    case 'modificarPaciente':
	    //	if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
	        	$paciente = RepositorioPaciente::getInstance()->buscarPaciente($_POST['id']);
	        	if(RepositorioPaciente::getInstance()->modificarPaciente($paciente)){
	        		listarPacientes();
	        	}
	       // }
	        break;
	    case 'eliminarPaciente':
	    	//if(($_SESSION['usuario'])->esAdministrador()){
	        	if(RepositorioPaciente::getInstance()->eliminarPaciente($_POST['id'])){
	        		listarPacientes();
	        	}
	       // }
	        break;
	    case 'mostrarPaciente':
	    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
	    		$paciente = RepositorioPaciente::getInstance()->buscarPaciente($_POST['id']);
	        	mostrarPaciente($paciente);
	       // }
	        break;
	    case 'listarPacientes':
	    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista() || ($_SESSION['usuario'])->esAdministrador()){
	    		$pacientes = RepositorioPaciente::getInstance()->devolverPacientes();
	        	listarPacientes($pacientes);
	       // }
	        break;
	    }
	}

*/




class ListarPacientes extends TwigView{
	public function show($pacientes) {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Administración de pacientes'));
        echo self::getTwig()->render('header.twig.html', array('roles' => $_SESSION['roles']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'listarPacientes','lista' => $pacientes,'titulo'=>'Pacientes'));
        echo self::getTwig()->render('footer.twig.html');
    }
}

?>