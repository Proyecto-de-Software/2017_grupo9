
<section class="row mx-auto mt-5 ">
	<div class="login col-md-7  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
		@if(isset($user))
			@php 
				$titulo = 'Editar usuario';
				$firstNameValue = 'value='.$user->first_name;
				$lastNameValue = 'value='.$user->last_name;
				$userNameValue = 'value='.$user->username;
				$emailValue = 'value='.$user->email;

			@endphp
		@else
			@php 
				$titulo = 'Nuevo usuario';
				$firstNameValue = '';
				$lastNameValue = '';
				$userNameValue = '';
				$emailValue = '';
			@endphp
		@endif
			<h3 class="card-header text-center myHeader"> {{ $titulo }}</h3>
			<form class="text-center" role="form" method="POST" " action="{{url('/user')}}">
		
				<div class="form-group row ">
					    <label for="nombre"  class="col-sm-3 mt-3 col-form-label">Nombre</label>
					    <input type="text" class="form-control mt-3 col-sm-8" id="nombre" name="nombre" placeholder="Nombre" {{$firstNameValue}} required>
				 </div>
			  	<div class="form-group row ">
				    <label for="apellido" class="col-sm-3 mt-3 col-form-label">Apellido</label>
				    <input type="text" class="form-control mt-3 col-sm-8" id="apellido" name="apellido" placeholder="Apellido" {{$lastNameValue}} required>
			  	</div>
			  	<div class="form-group row ">
				    <label for="usuario" class="col-sm-3 mt-3 col-form-label">Usuario</label>
				    <input type="text" class="form-control mt-3 col-sm-8" id="usuario"  name="usuario" placeholder="Usuario"  {{$userNameValue}} required >
			  	</div>
			  	<div class="form-group row">
			    	<label for="email" class="col-sm-3 mt-3 col-form-label">Email</label>
			   		<input type="text" class="form-control mt-3 col-sm-8" id="email" name="email" placeholder="Email" {{$emailValue}} required>
				</div>
			 	<div class="form-group row">
			    	<label for="password" class="col-sm-3 mt-3 col-form-label">Contraseña</label>
			   		<input type="password" class="form-control mt-3 col-sm-8" id="password" name="password" placeholder="Contraseña" " required>
				</div>
				
				<div class="form-group row">
			    	<label for="password2" class="col-sm-3 mt-3 col-form-label">Confirmación</label>
			   		<input type="password" class="form-control mt-3 col-sm-8" id="password2" name="password2" placeholder="Repita contraseña" required>
				</div>
		
				
				
				agregar parte de roles
				<hr>

				<button type="submit" class="btn btn-outline-success  btn-own-info">Agregar</button>
		</form>
	</div>
</section>