<!-- este template recibe parametros: tipo (usuarios o pacientes) y action (accion url, ej /filtrado, o /busquedaNombre) -->
<div class="d-flex justify-content-center">
	<nav aria-label="...">
	  <ul class="pagination ">
	  	@if($paginado->actual > 1)
	  		{{ $anterior = paginado->actual-1 }}
		    <li class="page-item ">
		      <a class="page-link page-link-own" href="/index.php/{{tipo}}{{action}}?page={{anterior}}" >Anterior</a>
		    </li>
		@else
			<li class="page-item disabled">
		      <a class="page-link " href="#">Anterior</a>
		    </li>
		@endif

		@foreach( range(1, paginado->cantidadPaginas) as $numero )
			@if( $paginado->actual == pagina)}
		    	<li class="page-item active">
		    		<a class="page-link page-link-own-active " href="/index.php/{{tipo}}{{action}}?page={{pagina}}">{{pagina}}</a>
		    	</li>
		    @else
		    	<li class="page-item">
		    		<a class="page-link page-link-own " href="/index.php/{{tipo}}{{action}}?page={{pagina}}">{{pagina}}</a>
		    	</li>
		    @endif
		@endforeach
		@if(paginado->actual < paginado->cantidadPaginas)
			{{ $siguiente = paginado->actual +1 }}
		    <li class="page-item">
		      <a class="page-link page-link-own" href="/index.php/{{tipo}}{{action}}?page={{siguiente}}">Siguiente</a>
		    </li>
		@else
			<li class="page-item disabled">
		      <a class="page-link " href="#">Siguiente</a>
		    </li>
		@endif
	  </ul>
	</nav>
</div>
	