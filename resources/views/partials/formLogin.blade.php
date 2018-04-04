<section class="row mx-auto mt-5 ">
	<div class="login col-md-4 text-center mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
		
		<h3 class="card-header text-center myHeader">Iniciar sesión </h3>

		{!! Form::open(
			array(
				'route' => 'session.login',
				'method' => 'POST'
			),	
			array(
				'role' => 'form',
				'class' => 'text-center'
			))
		!!}
		  	<div class="form-group ">
				{!! Form::label('email', 'Email',[
			    	'hidden'=>'true'
			    	]) 
		    	!!}
				{!! Form::text('email', null , array(
					'placeholder' => 'Email',
				 	'class' => 'form-control mt-3', 
				 	'required' =>true
				 	)) 
				!!}
		  	</div>
		 	 <div class="form-group">
		  		{!! Form::label('password', 'Contraseña',[
		  			'hidden'=>'true'
		  			]) 
			  	!!}
				{!! Form::password('password',array(
					'placeholder' => 'Contraseña',
				 	'class' => 'form-control mt-3', 
				 	'required' =>true
				 	)) 
				 !!}
			</div>
			{!! Form::button('Iniciar sesión', array(
				'type' => 'submit',
				'class' => 'btn btn-outline-success  btn-own-info'
				)) 
			!!}

		{!! Form::close() !!}
	</div>
</section>