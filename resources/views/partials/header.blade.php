<header>
	<nav class="navbar navbar-expand-lg navbar-light nav-own">
					<a class="navbar-brand nav-bar-link-own " href="/../">
		 			<img class="mr-2 d-inline-block align-center" src="/templates/img/logo.JPG" alt="logo del hospital" style="width:48px; height: 49px;">
						{{ $configuration->title }}
		  			</a>
				
				  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  			<span class="navbar-toggler-icon"></span>
		 			</button>
		 			@section('navegation')
				  		<div class="collapse navbar-collapse float-right" id="navbarSupportedContent">	
							@section('options')
								@if('pediatra' in usuarioActual.roles || 'recepcionista' in usuarioActual.roles || 'administrador' in usuarioActual.roles)
									@include('partials.patientOptions')
								@endif

								@if('administrador' in usuarioActual.roles)
									@include('partials.adminOptions')
								@endif
							@stop

					    	@section('session')
					    		include('partials.session')
					    	@stop
						</div>
					@stop
	</nav>
</header>