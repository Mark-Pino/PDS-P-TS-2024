@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Lista de Sueldos Pagados</h4>
                    <p class="mb-0">Un panel de pago de salarios te permite recopilar y visualizar fácilmente los datos de pago de salarios para optimizar la <br> experiencia del pago de salarios, asegurando la retención del pago de salarios. </p>
                </div>
                <div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('pay-salary.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Filas:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row" onchange="this.form.submit()">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2 align-self-center " for="search">Buscar:</label>
                        <div class="input-group col-sm-10">
                            <input type="text" id="search" class="form-control" name="search" placeholder="Empleado" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Buscar"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                <a href="{{ route('pay-salary.index') }}" class="input-group-text bg-danger"
                                data-toggle="tooltip" data-placement="top" title="" data-original-title="Borrar"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>#</th>
                            <th>Foto</th>
                            <th>@sortablelink('employee_id', 'Empleado')</th>
                            <th>@sortablelink('date', 'Fecha')</th>
                            <th>@sortablelink('advance_salary', 'Adelanto de Sueldo')</th>
                            <th>Sueldo</th>
                            <th>Pendiente</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @forelse ($advanceSalaries as $advanceSalary)
                        <tr>
                            <td>{{ (($advanceSalaries->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <img class="avatar-60 rounded" src="{{ $advanceSalary->employee->photo ? asset('storage/employees/'.$advanceSalary->employee->photo) : asset('assets/images/user/1.png') }}">
                            </td>
                            <td>{{ $advanceSalary->employee->name }}</td>
                            <td>{{ Carbon\Carbon::parse($advanceSalary->date)->format('M/Y') }}</td>
                            <td>{{ $advanceSalary->advance_salary ? '$'.$advanceSalary->advance_salary : 'Sin adelanto' }}</td>
                            <td>${{ $advanceSalary->employee->salary }}</td>
                            <td>${{ $advanceSalary->employee->salary - $advanceSalary->advance_salary }}</td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <a class="btn btn-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Pagar"
                                        href="{{ route('pay-salary.paySalary', $advanceSalary->id) }}">Pagar</i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <div class="alert text-white bg-danger" role="alert">
                            <div class="iq-alert-text">Datos no encontrados.</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ri-close-line"></i>
                            </button>
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $advanceSalaries->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
