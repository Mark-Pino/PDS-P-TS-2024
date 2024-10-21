@extends('auth.body.main')

@section('container')
<div class="container">
    <div class="row align-items-center justify-content-center min-vh-100">
        <div class="col-lg-8 col-md-10">
            <div class="card auth-card shadow-lg">
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Formulario -->
                        <div class="col-lg-12 align-self-center">
                            <h2 class="mb-4 text-center">Regístrate</h2>
                            <p class="text-center">Crea tu cuenta para comenzar.</p>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <!-- Nombre -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input
                                                type="text"
                                                name="name"
                                                id="name"
                                                value="{{ old('name') }}"
                                                class="form-control @error('name') is-invalid @enderror"
                                                required
                                                autofocus
                                            >
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Usuario -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="username">Usuario</label>
                                            <input
                                                type="text"
                                                name="username"
                                                id="username"
                                                value="{{ old('username') }}"
                                                class="form-control @error('username') is-invalid @enderror"
                                                required
                                            >
                                            @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Correo -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email">Correo</label>
                                            <input
                                                type="email"
                                                name="email"
                                                id="email"
                                                value="{{ old('email') }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                required
                                            >
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Contraseña -->
                                    <div class="col-lg-6">
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
                                    <!-- Confirmar Contraseña -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmar Contraseña</label>
                                            <input
                                                type="password"
                                                name="password_confirmation"
                                                id="password_confirmation"
                                                class="form-control"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <!-- Botón de registro -->
                                    <button type="submit" class="btn btn-primary btn-block mt-4">Registrarse</button>
                                </div>
                            </form>

                            <p class="text-center mt-3">
                                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-primary">Inicia sesión aquí</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
