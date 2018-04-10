
<section class="row mx-auto mt-5 ">
	<div class="login col-md-7  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">

		@include('partials.error')

		@if(isset($user))
			@php 
				$titulo = 'Editar usuario';
				$firstNameValue = $user->first_name;
				$lastNameValue = $user->last_name;
				$userNameValue = $user->username;
				$emailValue = $user->email;
				$route = ['user.update',$user->id];
				$method = 'PUT';
				

			@endphp
		@else
			@php 
				$titulo = 'Nuevo usuario';
				$firstNameValue = null;
				$lastNameValue = null;
				$userNameValue =null;
				$emailValue = null;
				$route = 'user.store';
				$method = 'POST';
			@endphp
		@endif
			<h3 class="card-header text-center myHeader"> {!! $titulo !!}</h3>
			{!! Form::open(array('route' => $route, 'method' => $method), array('role' => 'form', 'class' => 'text-center')) !!}
		
				<div class="form-group row ">
					{!! Form::label('nombre', 'Nombre',[
						'class'=>'col-sm-3 mt-3 col-form-label'
						]) 
					!!}
					{!! Form::text('nombre', $firstNameValue, array(
						'placeholder' => 'Nombre',
					 	'class' => 'form-control mt-3 col-sm-8', 
					 	'required' =>true
					 	)) 
					 !!}
					    
				 </div>
			  	<div class="form-group row ">
				    {!! Form::label('apellido', 'Apellido',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
				    !!}
					{!! Form::text('apellido', $lastNameValue, array(
						'placeholder' => 'Apellido',
					 	'class' => 'form-control mt-3 col-sm-8', 
					 	'required' =>true
					 	)) 
					 !!}
			  	</div>
			  	<div class="form-group row ">
			  		{!! Form::label('usuario', 'Usuario',[
			  			'class'=>'col-sm-3 mt-3 col-form-label'
			  			]) 
			  		!!}
					{!! Form::text('usuario', $userNameValue, array(
						'placeholder' => 'Nombre de usuario',
					 	'class' => 'form-control mt-3 col-sm-8', 
					 	'required' =>true
					 	)) 
					 !!}
			  	</div>
			  	<div class="form-group row">
			  		{!! Form::label('email', 'Email',[
				  		'class'=>'col-sm-3 mt-3 col-form-label'
				  		]) 
			  		!!}
					{!! Form::text('email', $emailValue, array(
						'placeholder' => 'Email',
					 	'class' => 'form-control mt-3 col-sm-8', 
					 	'required' =>true
					 	)) 
					 !!}
				</div>
			 	<div class="form-group row">
			  		{!! Form::label('password', 'Contraseña',[
			  			'class'=>'col-sm-3 mt-3 col-form-label'
			  			]) !!}
					{!! Form::password('password',array(
						'placeholder' => 'Contraseña',
					 	'class' => 'form-control mt-3 col-sm-8', 
					 	'required' =>true
					 	)) 
					 !!}
				</div>
				
			 	<div class="form-group row">
			  		{!! Form::label('password2', 'Contraseña',[
			  		'class'=>'col-sm-3 mt-3 col-form-label'
			  		]) !!}
					{!! Form::password('password2',array(
						'placeholder' => 'Repita contraseña',
					 	'class' => 'form-control mt-3 col-sm-8', 
					 	'required' =>true
					 	)) 
					 !!}
				</div>
				<hr>
					<div class="form-group row form-check " >
						<div class="col-sm-2 mt-3 col-form-label ">Roles:</div>
						<div class="col-sm-9 mt-3 ">
							@if(!isset($userRols))
								@php
									$userRols = array();
								@endphp
							@endif
							@foreach($rols as $rol)
								{!! Form::label('rol', $rol->name) !!}
								{!! Form::checkbox('rol[]', $rol->id, in_array($rol->id,$userRols), array(
								 	'class' => 'checkbox col-sm-1 '
								 	)) 
							 	!!}	
			     			@endforeach
			     		</div>		
	  				</div>
				

				{!! Form::hidden('_token',csrf_token()) !!}
				<hr>
				<div class="text-center">
				{!! Form::button('Listo', array(
					'type' => 'submit',
					 'class' => 'btn btn-outline-success  pl-4 pr-4 btn-own-info'
					 )) 
				!!}
				</div>  


				{!! Form::close() !!}
		
	</div>
</section>