
<section>
	<h2> Usuarios</h2><br>
		<div class="mb-4 mt-4">
			<h3 >Filtrado </h3> 
			<form  id="form" class="form-inline my-2 my-lg-0 ml-auto mr-5 d-flex justify-content-start" action="/index.php/usuarios/filtrado" method="POST">
				<input type="hidden" name="filtrado">		
				@if($filtrado != null)
	      			<input class="form-control mr-sm-2 " type="text" placeholder="Buscar" aria-label="Buscar" name="buscar" id="buscar" value="{{filtrado.campoBuscar}}">
	      		@else
	      			<input class="form-control mr-sm-2 " type="text" placeholder="Buscar" aria-label="Buscar" name="buscar" id="buscar">
	      		@endif

	      		@(if $filtrado->activo)
					<input type="checkbox" name="activo" id="activo" class="checkbox mr-2 ml-2" value="activo" checked> 
				@else
					<input type="checkbox" name="activo" id="activo" class="checkbox mr-2 ml-2" value="activo">  
				@endif
    			<label for="rol">Activo</label><br/>

    			@(if $filtrado->bloqueado) 
					<input type="checkbox" name="bloqueado" id="bloqueado" class="checkbox mr-2 ml-2" value="bloqueado" checked={{filtrado.bloqueado}}>
				@else
					<input type="checkbox" name="bloqueado" id="bloqueado" class="checkbox mr-2 ml-2" value="bloqueado">
				@endif
    			<label for="rol">Bloqueado</label><br/>
	      		<button class="btn btn-success btn-search btn-own  my-2 my-sm-0 mr-2 ml-2" type="submit">Filtrar</button>
		    </form>
		</div>
		<table class="table table-hover">
		  	<thead>
			    <tr>
			    	<th>Nombre de usuario</th>

			    </tr>
		  	</thead>
		  	<tbody>
			  	@foreach($lista as $elemento)
				    <tr>
				    	<td>{{ $elemento->nombreUsuario }}</td>
				    	<td>
				    		<a href="/index.php/usuario/{{elemento.id}}/edicion" class="btn btn-outline-success btn-own-info">Editar</a>
				    	</td>
				    	<td>
				    		<a onclick="return confirm('Seguro?')"  href="/index.php/usuario/{{ elemento.id }}/eliminar" class="btn btn-outline-success btn-own-info">Eliminar </a>
				    	</td>
			      		<td>
				      		@(if $elemento->activo)
				      			<a href="/index.php/usuario/{{ elemento.id }}/bloquear" class="btn btn-outline-success btn-own-info"> Bloquear </a>
				      		@else
				      			<a href="/index.php/usuario/{{ elemento.id }}/activar" class="btn btn-outline-success btn-own-info"> Activar </a>
			      			@endif	
				      	</td>
				      	<td>
				      		<a href="/index.php/usuario/{{ elemento.id }}" class="btn btn-outline-success btn-own-info">Mas información</a>
				      	</td>
				    </tr>
			     @endforeach
			    
			</tbody>
		</table>
		<a class="btn btn-success btn-own mt-3 mb-5 text-right" role="button" href="/index.php/usuarios/nuevo">
			Agregar nuevo usuario
		</a>
		

</section>
