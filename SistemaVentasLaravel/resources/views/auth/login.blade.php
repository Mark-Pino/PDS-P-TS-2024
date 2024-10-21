@extends('auth.body.main')

@section('container')
<div class="container">
    <div class="row align-items-center justify-content-center min-vh-100">
        <div class="col-lg-8 col-md-10">
            <div class="card auth-card shadow-lg">
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Formulario de inicio de sesión -->
                        <div class="col-lg-12 align-self-center">
                            <h2 class="mb-4 text-center">Iniciar sesión</h2>
                            <p class="text-center">Inicia sesión para mantenerte conectado.</p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row">
                                    <!-- Usuario -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="input_type">Usuario</label>
                                            <input
                                                type="text"
                                                name="input_type"
                                                id="input_type"
                                                value="{{ old('input_type') }}"
                                                class="form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror"
                                                required
                                                autofocus
                                            >
                                            @error('username')
                                            <div class="invalid-feedback">Incorrecto Usuario o Contraseña.</div>
                                            @enderror
                                            @error('email')
                                            <div class="invalid-feedback">Incorrecto Usuario o Contraseña.</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Contraseña -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="password">Contraseña</label>
                                            <input
                                                type="password"
                                                name="password"
                                                id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                required
                                            >
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Links de registro y recuperación de contraseña -->
                                    <div class="col-lg-6">
                                        <p>¿Todavía no tienes una cuenta? <a href="{{ route('register') }}" class="text-primary">Registrarse</a></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#" class="text-primary float-right">¿Olvidaste tu contraseña?</a>
                                    </div>

                                    <!-- Botón de inicio de sesión -->
                                    <button type="submit" class="btn btn-primary btn-block mt-4">Iniciar sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
