<?php
#Mostrar errores:
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
#Notificar todos los errores de PHP:
error_reporting(-1);

require_once($_SERVER['DOCUMENT_ROOT']."/controller/ControllerSeguridad.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ResourceController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/PDORepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ResourceRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/Resource.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioUsuario.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioRol.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ClaseUsuario.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioConfiguracion.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ClaseConfiguracion.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');

function obtenerConfiguracion(){
	$config = RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion();
	$datosConfigurados =array(
		'habilitado' => $config->getHabilitado(),
        'hospital' => $config->getDescripcionHospital(),
        'guardia' => $config->getDescripcionGuardia(),
        'titulo' => $config->getTitulo(),
        'especialidades' => $config->getDescripcionEspecialidades(),
        'contacto' => $config->getContacto()
    );
    return $datosConfigurados;
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

$config = obtenerConfiguracion();
if(!$config['habilitado']){
	echo TwigView::getTwig()->render('mantenimiento.twig', array('configuracion'=>obtenerConfiguracion()));
}
else{


	if(!isset($_SESSION)) {
		sec_session_start();
	} else {
		session_regenerate_id();
	} 

	if(!isset($_SESSION['usuario'])) {
		$_SESSION['usuario'] = NULL;
		$_SESSION['logueado'] = NULL;
		$_SESSION['administrador']=0;
		$_SESSION['recepcionista']=0;
		$_SESSION['pediatra']=0;
	}
	echo TwigView::getTwig()->render('base.twig.html', array('usuarioActual' => usuarioActual(),'configuracion'=>obtenerConfiguracion()));
	
}
