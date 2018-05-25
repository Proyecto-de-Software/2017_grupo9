@extends('base')

@section('container')
    <section class="row mx-auto mt-5 ">
        <div class="login col-md-4  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
            <h3 class="card-header text-center myHeader">Iniciar sesión </h3>
            <form class="text-center" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" hidden>Usuario</label>
                    <input type="email" class="form-control mt-3" id="email" value="{{ old('email') }}" name="email" placeholder="Email" required autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                 <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" hidden>Contraseña</label>
                    <input type="password" class="form-control mt-3" id="password" name="password" placeholder="Contraseña" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-outline-success  btn-own-info">Iniciar sesión</button>
            </form>
        </div>
    </section>
@endsection
