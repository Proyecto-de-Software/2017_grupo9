<header>
	<nav class="navbar navbar-expand-lg navbar-light nav-own">
		<a class="navbar-brand nav-bar-link-own " href="">
			<img class="mr-2 d-inline-block align-center" src="{{ asset('img/logo.JPG') }}" alt="logo del hospital" style="width:48px; height: 49px;">	
		</a>
	
	  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		@section('navegacion')
	  		<div class="collapse navbar-collapse float-right" id="navbarSupportedContent">	
	  			@if(Auth::check())
		  			@include('partials.opcionesPaciente')
		  			@include('partials.opcionesAdmin')
		  		@endif
				@include('partials.session')
			</div>
		@show
		
	</nav>
</header>