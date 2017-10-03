<?php
	class Paciente{
		private $apellido;
		private $nombre;
		private $domicilio;
		private $tel;
		private $fechaNacimiento;
		private $genero;
		private $idDatosDemograficos;
		private $idObraSocial;
		private $idTipoDocumento;
		private $numero;

		private function __construct($apellido,$nombre,$domicilio,$tel,$fechaNacimiento,$genero,$idDatosDemograficos,$idObraSocial,$idTipoDocumento,$numero){
        	this=>$apellido = $apellido;
        	this=>$nombre = $nombre;
        	this=>$domicilio = $domicilio;
        	this=>$tel = $tel;
        	this=>$fechaNacimiento = $fechaNacimiento;
        	this=>$genero = $genero;
        	this=>$idDatosDemograficos = $idDatosDemograficos;
        	this=>$idObraSocial = $idObraSocial;
        	this=>$idTipoDocumento = $idTipoDocumento;
        	this=>$numero = $numero;
    	}
	}
