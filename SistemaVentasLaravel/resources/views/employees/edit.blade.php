@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Editar Empleado</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                        <!-- begin: Input Image -->
                        <div class="form-group row align-items-center">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <div class="crm-profile-img-edit">
                                        <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $employee->photo ? asset('storage/employees/'.$employee->photo) : asset('assets/images/user/1.png') }}" alt="profile-pic">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group mb-4 col-lg-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="image" name="photo" accept="image/*" onchange="previewImage();">
                                    <label class="custom-file-label" for="photo">Elegir Foto</label>
                                </div>
                                @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Image -->
                        <!-- begin: Input Data -->
                        <div class=" row align-items-center">
                            <div class="form-group col-md-12">
                                <label for="name">Nombre del Empleado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Correo del Empleado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Télefono del Empleado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" required>
                                @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="experience">Experiencia del Empleado</label>
                                <select class="form-control" name="experience">
                                    <option value="" disabled>--Selecionar Año--</option>
                                        <option value="0 Años" @if(old('experience', $employee->experience) == '0 Años')selected="selected"@endif>0 Años</option>
                                        <option value="1 Año" @if(old('experience', $employee->experience) == '1 Año')selected="selected"@endif>1 Año</option>
                                        <option value="2 Años" @if(old('experience', $employee->experience) == '2 Años')selected="selected"@endif>2 Años</option>
                                        <option value="3 Años" @if(old('experience', $employee->experience) == '3 Años')selected="selected"@endif>3 Años</option>
                                        <option value="4 Años" @if(old('experience', $employee->experience) == '4 Años')selected="selected"@endif>4 Años</option>
                                        <option value="5 Años" @if(old('experience', $employee->experience) == '5 Años')selected="selected"@endif>5 Años</option>
                                        <option value="6 Años" @if(old('experience', $employee->experience) == '6 Años')selected="selected"@endif>6 Años</option>
                                        <option value="7 Años" @if(old('experience', $employee->experience) == '7 Años')selected="selected"@endif>7 Años</option>
                                        <option value="8 Años" @if(old('experience', $employee->experience) == '8 Años')selected="selected"@endif>8 Años</option>
                                        <option value="9 Años" @if(old('experience', $employee->experience) == '9 Años')selected="selected"@endif>9 Años</option>
                                        <option value="10 Años" @if(old('experience', $employee->experience) == '10 Años')selected="selected"@endif>10 Años</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="salary">Salario del Empleado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary', $employee->salary) }}" required>
                                @error('salary')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="vacation">Días de Descanso</label>
                                <input type="text" class="form-control @error('vacation') is-invalid @enderror" id="vacation" name="vacation" value="{{ old('vacation', $employee->vacation) }}">
                                @error('vacation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="city">Ciudad del Empleado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $employee->city) }}" required>
                                @error('city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Dirección del Empleado <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" required>{{ old('address',$employee->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary mr-2">Editar</button>
                            <a class="btn bg-danger" href="{{ route('employees.index') }}">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

@include('components.preview-img-form')
@endsection
