<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupController extends Controller
{    public function index()
    {
        return view('database.index', [
            'files' => File::allFiles(storage_path('/app/laravel'))
        ]);
    }

    // Backup database is not working, and you need to enter manually in terminal with command php artisan backup:run.
    public function create(){
        Artisan::call('backup:run'); //No funciona guiño guiño xD

        return Redirect::route('backup.index')->with('success', '¡Base de datos creado con éxito!');
    }

    public function download(String $getFileName)
    {
        $path = storage_path('app\laravel/' . $getFileName);

        return response()->download($path);
    }

    public function delete(String $getFileName)
    {
        Storage::delete('laravel/' . $getFileName);

        return Redirect::route('backup.index')->with('success', '¡Base de datos eliminada con éxito!');
    }
}
