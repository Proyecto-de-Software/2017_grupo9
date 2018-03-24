<?php
	class Configuracion{
        private $id;
		private $titulo;
		private $descripcionHospital;
        private $descripcionGuardia;
        private $descripcionEspecialidades;
		private $contacto;
		private $cantElem;
		private $habilitado;

		public function __construct($titulo, $descripcionHospital,$descripcionGuardia,$descripcionEspecialidades, $contacto, $cantElem, $habilitado){
            $this->titulo = $titulo;
        	$this->descripcionHospital = $descripcionHospital;
            $this->descripcionGuardia = $descripcionGuardia;
            $this->descripcionEspecialidades = $descripcionEspecialidades;
        	$this->contacto = $contacto;
        	$this->cantElem = $cantElem;
        	$this->habilitado = $habilitado;
		}

        public function getTitulo(){
        	return $this->titulo;
        }

        public function setTitulo($titulo){
        	$this->titulo = $titulo;
        }

        public function getDescripcionHospital(){
        	return $this->descripcionHospital;
        }

        public function setDescripcionHospital($descripcionHospital){
            $this->descripcionHospital = $descripcionHospital;
        }

        public function setDescripcionGuardia($descripcionGuardia){
            $this->descripcionGuardia = $descripcionGuardia;
        }
        public function getDescripcionGuardia(){
            return $this->descripcionGuardia;
        }
        public function setDescripcionEspecialidades($descripcionEspecialidades){
            $this->descripcionEspecialidades = $descripcionEspecialidades;
        }
        public function getDescripcionEspecialidades(){
            return $this->descripcionEspecialidades;
        }

        public function getContacto(){
        	return $this->contacto;
        }

        public function setContacto($contacto){
        	$this->contacto = $contacto;
        }

        public function getCantElem(){
        	return $this->cantElem;
        }

        public function setCantElem($cantElem){
        	$this->cantElem = $cantElem;
        }

        public function getHabilitado(){
        	return $this->habilitado;
        }

        public function setHabilitado($habilitado){
        	$this->habilitado = $habilitado;
        }
        public function setId($id){
            $this->id = $id;
        }
        public function getId(){
            return $this->id;
        }
        public function esValida(){
            $validacion['ok'] = true;
            $titulo = $this->getTitulo() != null && trim($this->getTitulo()) !='';
            if(!$titulo){
                array_push($validacion, 'El titulo no debe estar vacio');
                $validacion['ok'] = false;
            }
            $dHospital = $this->getDescripcionHospital() != null && trim($this->getDescripcionHospital()) !='';
            if(!$dHospital){
                array_push($validacion, 'La descripcion del hospital no debe estar vacia');
                $validacion['ok'] = false;
            }
            $dEspecialidades = $this->getDescripcionEspecialidades() != null && trim($this->getDescripcionEspecialidades()) !='';
            if(!$dEspecialidades){
                array_push($validacion, 'La descripcion de especialidades no debe estar vacia');
                $validacion['ok'] = false;
            }
            $dGuardia = $this->getDescripcionGuardia() != null && trim($this->getDescripcionGuardia()) !='';
            if(!$dGuardia){
                array_push($validacion, 'La descripcion de la guardia no debe estar vacia');
                $validacion['ok'] = false;
            }
            $cantElem = $this->getCantElem() != null  && trim($this->getCantElem()) !='';
            if(!$cantElem){
                array_push($validacion, 'Debe indicar una cantidad de elementos por pagina');
                $validacion['ok'] = false;
            }
            $emailContacto = $this->getContacto() != null && filter_var($this->getContacto(),FILTER_VALIDATE_EMAIL);
            if(!$emailContacto){
                array_push($validacion, 'El mail no debe ser vacion y debe ser un email con formato valido');
                $validacion['ok'] = false;
            }
            return $validacion;
        }
    }