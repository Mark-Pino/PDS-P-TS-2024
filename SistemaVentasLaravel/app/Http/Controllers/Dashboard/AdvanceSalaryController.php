<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\AdvanceSalary;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AdvanceSalaryController extends Controller
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

        if(request('search')){
            Employee::firstWhere('name', request('search'));
        }

        return view('advance-salary.index', [
            'advance_salaries' => AdvanceSalary::with(['employee'])
                ->sortable()
                ->orderByDesc('date')
                ->filter(request(['search']))
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('advance-salary.create', [
            'employees' => Employee::all()->sortBy('name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'employee_id' => 'required',
            'date' => 'required|date_format:Y-m-d|max:10',
            'advance_salary' => 'numeric|nullable'
        ];

        if ($request->date) {
            // format date only shows the year and month
            $getYm = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m');
        } else {
            $validatedData = $request->validate($rules);
        }


        $advanced = AdvanceSalary::where('employee_id', $request->employee_id)
            ->whereDate('date', 'LIKE',  $getYm . '%')
            ->get();

        if ($advanced->isEmpty()) {
            $validatedData = $request->validate($rules);
            AdvanceSalary::create($validatedData);

            return Redirect::route('advance-salary.index')->with('success', 'Advance Salary Paid Successfully!');
        } else {
            return Redirect::route('advance-salary.index')->with('warning', 'Advance Salary Already Paid!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AdvanceSalary $advanceSalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdvanceSalary $advanceSalary)
    {
        return view('advance-salary.edit', [
            'employees' => Employee::all()->sortBy('name'),
            'advance_salary' => $advanceSalary,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdvanceSalary $advanceSalary)
{
    $rules = [
        'employee_id' => 'required',
        'date' => 'required|date_format:Y-m-d|max:10',
        'advance_salary' => 'required|numeric'
    ];

    // Validamos los datos
    $validatedData = $request->validate($rules);

    // Formateamos la fecha para comparar año y mes (Y-m)
    $newYm = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m');
    $oldYm = Carbon::createFromFormat('Y-m-d', $advanceSalary->date)->format('Y-m');

    // Verificamos si hay un registro adelantado en el mismo mes y empleado
    $advanced = AdvanceSalary::where('employee_id', $request->employee_id) // Ojo aquí, usar $request->employee_id
        ->where('id', '!=', $advanceSalary->id) // Ignorar el actual en la búsqueda
        ->whereDate('date', 'LIKE', $newYm . '%')
        ->first();

    // Si no hay adelanto en la misma fecha, actualizamos
    if (!$advanced || $newYm == $oldYm) {
        // Actualizamos el registro
        $advanceSalary->update($validatedData);

        return Redirect::route('advance-salary.index', $advanceSalary->id)
            ->with('success', 'Advance Salary Updated Successfully!');
    } else {
        return Redirect::route('advance-salary.index', $advanceSalary->id)
            ->with('warning', 'Advance Salary Already Paid for this month!');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdvanceSalary $advanceSalary)
    {
        AdvanceSalary::destroy($advanceSalary->id);

        return Redirect::route('advance-salary.index')->with('success', 'Advance Salary has been deleted!');
    }
}
