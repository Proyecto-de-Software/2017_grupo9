@if(Auth::user()->hasRole('recepcionista') || Auth::user()->hasRole('administrador'))
	<ul class="navbar-nav float-right ">
		<li class="nav-item active">
				<a class="nav-link  nav-bar-link-own" role="button" href="{{ url('/patient')}}" > Pacientes </a>
		</li>
	</ul>
@endif