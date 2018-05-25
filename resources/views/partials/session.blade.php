<ul class=" ml-auto navbar-nav float-right">
	@if(Auth::check())
		@php
			$id = Auth::user()->id;
		@endphp
		<a class="nav-link nav-bar-link-own  mr-2" role="submit" href='{{url("user/$id")}}'>
			{{Auth::user()->username}}
		</a>

	    <li class="nav-item active">
	       	<a 	href="{{ route('logout') }}" 
	       		class="nav-link  nav-bar-link-own  mr-2" role="button"
	       		onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
	       			Cerrar sesión
	    	</a>
    	</li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
       	</form>
	@else
	    <li class="nav-item active">
	        <a class="nav-link  nav-bar-link-own  mr-2" role="button" href="{{url('login')}}">Iniciar sesión</a>
	    </li>
	@endif
</ul>