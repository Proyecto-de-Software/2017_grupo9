function validarRoles(){
	var ok = false;
	var checkboxs = document.getElementsByName('rol[]'); 
	for (var i = 0; i < checkboxs.length; i++) {
	    if(checkboxs[i].checked){
	   		ok=true;
	   	}
	}
	if(!ok){
		alert("Debe seleccionar al menos un rol");
	}
	return ok;
}