<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use App\Models\Attendence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;

class AttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('attendence.index', [
            'attendences' => Attendence::filter(request(['search']))
                ->sortable()
                ->select('date')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendence.create', [
            'employees' => Employee::all()->sortBy('name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Asignar la fecha de hoy si el campo 'date' no está presente o está vacío
        if (empty($request->date)) {
            $request->merge(['date' => now()->format('Y-m-d')]);
        }
        
        // Contar la cantidad de empleados
        $countEmployee = count($request->employee_id);

        // Definir las reglas de validación
        $rules = [
            'date' => 'required|date_format:Y-m-d|max:10',
        ];

        $validatedData = $request->validate($rules);

        // Verificar si ya existen registros de asistencia para la fecha
        $existingAttendance = Attendence::where('date', $validatedData['date'])->exists();

        // Eliminar registros anteriores si existen (para actualizar)
        Attendence::where('date', $validatedData['date'])->delete();

        // Crear o actualizar asistencias
        for ($i = 1; $i <= $countEmployee; $i++) {
            $status = 'status' . $i;
            $attend = new Attendence();

            $attend->date = $validatedData['date'];
            $attend->employee_id = $request->employee_id[$i];
            $attend->status = $request->$status;

            $attend->save();
        }

        // Definir el mensaje de éxito según si es creación o actualización
        $message = $existingAttendance
            ? '¡La asistencia ha sido actualizada correctamente!'
            : '¡La asistencia ha sido creada exitosamente!';

        return Redirect::route('attendence.index')->with('success', $message);
    }


    /**
     * Display the specified resource.
     */
    public function show(Attendence $attendence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendence $attendence)
    {
        return view('attendence.edit', [
            'attendences' => Attendence::with(['employee'])->where('date', $attendence->date)->get(),
            'date' => $attendence->date
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendence $date)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendence $attendence)
    {
        // Verifica si existe asistencia para la fecha del registro proporcionado
        $attendenceRecords = Attendence::where('date', $attendence->date);

        // Verifica si hay registros de asistencia para esa fecha
        if ($attendenceRecords->exists()) {
            // Elimina todos los registros de asistencia para la fecha
            $attendenceRecords->delete();

            // Redirige con un mensaje de éxito
            return redirect()->route('attendence.index')->with('success', '¡Toda la asistencia de la fecha ha sido eliminada!');
        }

        // Si no se encuentra la asistencia, redirige con un mensaje de error
        return redirect()->route('attendence.index')->with('error', 'No se encontraron registros de asistencia para eliminar.');
    }

}
