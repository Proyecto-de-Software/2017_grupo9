<?php
	class TipoDocumento{
        private $id;
		private $nombre;

        function __construct($id, $nombre){
            $this->id = $id;
        	$this->nombre = $nombre;
    	}
    }
?>