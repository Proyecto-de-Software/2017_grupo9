<!DOCTYPE html>
	<html lang="es">

		@include('partials.head')

		@include('partials.header')

		<div class="container mt-5">
			@section('container')
				@include('partials.infoHome')
			@show
		</div>

		@include('partials.footer')
		
	</html>	