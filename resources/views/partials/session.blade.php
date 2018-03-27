<ul class=" ml-auto navbar-nav float-right">
	@if(usuarioActual.logueado)
		<a class="nav-link nav-bar-link-own  mr-2" role="submit" href="/index.php/usuario/{{usuarioActual.idUsuario}}">{{$usuarioActual->username}}</a>
	    <a class="nav-link nav-bar-link-own  mr-2" role="submit" href="/index.php/cerrarSesion">Cerrar sesión</a>
	@else
	    <li class="nav-item active">
	        <a class="nav-link  nav-bar-link-own  mr-2" role="button" href="/index.php/login">Iniciar sesión</a>
	    </li>
	 @endif

</ul>