<!DOCTYPE html>
	<html lang="es">
		@include('partials.head')
		<body>
			@include('partials.header')

			<div class="container mt-5">
				@section('container')
					@include('partials.infoHome')
				@show
			</div>
		</body>
		@section('footer')
			@include('partials.footer')
		@show
	</html>	