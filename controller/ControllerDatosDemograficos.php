<?php
	
	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);


	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioConfiguracion.php");

	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClasePaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioDatosDemograficos.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioRol.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPermiso.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/view/TwigView.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/controller/ControllerSeguridad.php");

	if(!isset($_SESSION)) {
		sec_session_start();
	} else {
		session_regenerate_id();
	}

	 function obtenerConfiguracion(){
      require_once($_SERVER['DOCUMENT_ROOT']."/view/Home.php");
      $config = RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion();
      $datosConfigurados =array(
        'habilitado' => $config->getHabilitado(),
        'titulo' => $config->getTitulo(),
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

    function usuarioActual(){
    	if(isset($_SESSION['idUsuario'])){
    		$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($_SESSION['idUsuario']);
    		return array(	'logueado'=>true, 
    						'username'=>$usuario->getNombreUsuario(),
    						'roles'=>RepositorioRol::getInstance()->buscarRolesDeUsuario($_SESSION['idUsuario']),
    						'idUsuario'=>$_SESSION['idUsuario'],
    						'token'=>$_SESSION['token']
    					);
    	}
    	else return false;
    }

	function crearDatosDemograficos(){
		$datosDemograficos = new DatosDemograficos($_POST['heladera'], $_POST['electricidad'], $_POST['mascota'], $_POST['tipoVivienda'], $_POST['tipoCalefaccion'], $_POST['tipoAgua'], $_POST['idPaciente']);
		return $datosDemograficos;
	}

	function mostrarDatosDemograficos($datosDemograficos,$tipoDeVivienda=null,$tipoDeCalefaccion=null,$tipoDeAgua=null){
		echo TwigView::getTwig()->render('administracionMostrarDatosDemograficos.twig', array('usuarioActual' => usuarioActual(), 'idPaciente' => $_GET['id'], 'datosDemograficos' => $datosDemograficos, 'tipoDeVivienda' => $tipoDeVivienda, 'tipoDeCalefaccion' => $tipoDeCalefaccion, 'tipoDeAgua' => $tipoDeAgua, 'configuracion'=>obtenerConfiguracion()));
	}

	function agregarDatosDemograficos($tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua){
		echo TwigView::getTwig()->render('administracionAgregarDatosDemograficos.twig', array('usuarioActual' => usuarioActual(), 'idPaciente' => $_GET['id'], 'tiposDeVivienda' => $tiposDeVivienda, 'tiposDeCalefaccion' => $tiposDeCalefaccion, 'tiposDeAgua' => $tiposDeAgua, 'configuracion'=>obtenerConfiguracion()));
	}

	function modificarDatosDemograficos($datosDemograficos,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua){
		echo TwigView::getTwig()->render('administracionModificarDatosDemograficos.twig', array('usuarioActual' => usuarioActual(), 'datosDemograficos' => $datosDemograficos, 'tiposDeVivienda' => $tiposDeVivienda, 'tiposDeCalefaccion' => $tiposDeCalefaccion, 'tiposDeAgua' => $tiposDeAgua, 'configuracion' => obtenerConfiguracion()));
	}


	if(isset($_GET['action'])){
		switch ($_GET['action']) {
			case 'altaDeDatosDemograficos':
				$datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarDatosDemograficosPorIdPaciente($_GET['id']);
    			$tiposDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTiposDeVivienda();
    			$tiposDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTiposDeCalefaccion();
    			$tiposDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTiposDeAgua();
				agregarDatosDemograficos($tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
	       		break;
	    	case 'agregarDatosDemograficos':
	    		if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_new')){
	    			$datosDemograficos = crearDatosDemograficos();

        			if(RepositorioDatosDemograficos::getInstance()->agregarDatosDemograficos($datosDemograficos)){
		    			$tipoDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTipoDeViviendaPorId($datosDemograficos->getTipoVivienda());
		    			$tipoDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTipoDeCalefaccionPorId($datosDemograficos->getTipoCalefaccion());
		    			$tipoDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTipoDeAguaPorId($datosDemograficos->getTipoAgua());
		       			mostrarDatosDemograficos($datosDemograficos,$tipoDeVivienda,$tipoDeCalefaccion,$tipoDeAgua);
		       		}
		       		else{
						$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    			$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
		       			agregarPaciente($obrasSociales,$tiposDeDocumento);
		       		}
		       	} else {
	    			header("Location: /../");
	    		}
	    		break;
	    	case 'mostrarDatosDemograficos':
	    		if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_show')){
	    			
	    			if($datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarDatosDemograficosPorIdPaciente($_GET['id'])){

	    				$tipoDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTipoDeViviendaPorId($datosDemograficos->getTipoVivienda());
	    				$tipoDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTipoDeCalefaccionPorId($datosDemograficos->getTipoCalefaccion());
	    				$tipoDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTipoDeAguaPorId($datosDemograficos->getTipoAgua());
	    				mostrarDatosDemograficos($datosDemograficos,$tipoDeVivienda,$tipoDeCalefaccion,$tipoDeAgua);
	    			}
	    			else{
	    				mostrarDatosDemograficos($datosDemograficos);
	    			}
	    			

	    		} else {
	    			header("Location: /../");
	    		}
	    		break;
	    	case 'modificacionDatosDemograficos':
	    		if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_update')){
	    			if($datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarDatosDemograficosPorId($_GET['id'])){
		    			$tiposDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTiposDeVivienda();
		    			$tiposDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTiposDeCalefaccion();
		    			$tiposDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTiposDeAgua();
		    			modificarDatosDemograficos($datosDemograficos,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
		    		}
	    		} else{
	    			header("Location: /../");
	    		}		

	    		break;
	    	case 'modificarDatosDemograficos':
	    		if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_update')){
	    			$datosDemograficos = crearDatosDemograficos();
	    			$datosDemograficos->setId($_GET['id']);
	    			if($datosDemograficosModificados = RepositorioDatosDemograficos::getInstance()->modificarDatosDemograficos($datosDemograficos)){
	    				$tipoDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTipoDeViviendaPorId($datosDemograficos->getTipoVivienda());
	    				$tipoDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTipoDeCalefaccionPorId($datosDemograficos->getTipoCalefaccion());
	    				$tipoDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTipoDeAguaPorId($datosDemograficos->getTipoAgua());
	    				mostrarDatosDemograficos($datosDemograficos,$tipoDeVivienda,$tipoDeCalefaccion,$tipoDeAgua);
	    			}
	    			else{
	    				$datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarDatosDemograficosPorId($_GET['id']);
	    				$tiposDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTiposDeVivienda();
		    			$tiposDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTiposDeCalefaccion();
		    			$tiposDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTiposDeAgua();
		    			modificarDatosDemograficos($datosDemograficos,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
	    			}
	    		} else{
	    			header("Location: /../");
	    		}
	    		break;
    		case 'eliminarDatosDemograficos':
    			if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_destroy')){
    				if($datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarDatosDemograficosPorIdPaciente($_GET['id'])){
    					
    					RepositorioDatosDemograficos::getInstance()->eliminarDatosDemograficos($datosDemograficos);
		        	}
		        	header("location: /../controller/ControllerPaciente.php/?action=listarPacientes");
		        } else {
	        		header("Location: /../");
    			}
    			break;
	    	}
		}