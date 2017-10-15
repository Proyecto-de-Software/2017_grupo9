function validarRoles(){
	var ok = false;
	var cboxs = document.getElementsById('rol[]');
	    for (cboxs in checkbox){
	        if(checkbox.checked){
	        	ok = true;
	        }
	    }
	    
	    if(!ok){
	    	document.getElementsById('mensajeDeValidacion').write = "* Debe elegir al menos un rol para el usuario"; 
	    	return false;
	    }
}