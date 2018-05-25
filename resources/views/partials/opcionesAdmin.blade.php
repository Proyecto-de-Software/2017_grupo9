@if(Auth::user()->hasRole('administrador'))
	<ul class="navbar-nav float-right ">
		<li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle nav-bar-link-own" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	         	Administración
	        </a>
			<div class="dropdown-menu" id="dropdown" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item dropdown-item-own" href="{{ url('/user')}}"	>Usuarios</a>
				<a class="dropdown-item dropdown-item-own" href="#">Roles</a>
				<a class="dropdown-item dropdown-item-own" href="#">Permisos</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item dropdown-item-own" href="{{ url('/configuration')}}">Configuración</a>
			</div>
	    </li>
	</ul>
@endif