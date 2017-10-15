function validarRoles(){
	var ok = false;
	var ckbox = document.getElementsById('rol[]');
	    for (var i=0; i < ckbox.length; i++){
	        if(ckbox[i].checked){
	        	ok = true;
	        }
	    }
	    
	    if(!ok){
	    	document.getElementsById('mensajeDeValidacion').write = "Debe elegir al menos un rol para el usuario"; 
	    	return false;
}