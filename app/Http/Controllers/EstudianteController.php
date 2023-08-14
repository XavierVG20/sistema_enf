<?php

namespace App\Http\Controllers;

use App\Exports\EstudiantesExport;
use App\Http\Requests\EstudianteRequest;
use App\Imports\EstudiantesImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Estudiante;

use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      if (!$request->ajax()) return view('estudiante');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $estudiantes = Estudiante::orderBy('id', 'desc')->paginate(5);
        }
        else{
            $estudiantes = Estudiante::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(5);
        }
         
 
        return [
            'pagination' => [
                'total'        => $estudiantes->total(),
                'current_page' => $estudiantes->currentPage(),
                'per_page'     => $estudiantes->perPage(),
                'last_page'    => $estudiantes->lastPage(),
                'from'         => $estudiantes->firstItem(),
                'to'           => $estudiantes->lastItem(),
            ],
            'estudiantes' => $estudiantes
        ];
    }

    public function selectEstudiante(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $estudiantes = Estudiante::where('nombre', 'like', '%'. $filtro . '%')
        ->orWhere('num_documento', 'like', '%'. $filtro . '%')
        ->select('id','nombre','num_documento')
        ->orderBy('nombre', 'asc')->get();
 
        return ['estudiantes' => $estudiantes];
    }

    public function store(EstudianteRequest $request)
    {         
            $estudiante = new Estudiante();
            $estudiante->nombre = $request->nombre;
            $estudiante->curso = $request->curso;
            $estudiante->num_documento = $request->num_documento;

            $estudiante->direccion = $request->direccion;
            $estudiante->rep_nombre = $request->rep_nombre;
            $estudiante->rep_documento = $request->rep_documento;
            $estudiante->telefono = $request->telefono;
            $estudiante->estado = 'activo';
            $estudiante->save();    
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
         
        try{
 
            //Buscar primero el proveedor a modificar
            $estudiante = Estudiante::findOrFail($request->id);
           
            $estudiante->nombre = $request->nombre;
            $estudiante->curso = $request->curso;
            $estudiante->num_documento = $request->num_documento;
            
            $estudiante->direccion = $request->direccion;
            $estudiante->rep_nombre = $request->rep_nombre;
            $estudiante->rep_documento = $request->rep_documento;
            $estudiante->telefono = $request->telefono;
            $estudiante->estado = 'activo';
            $estudiante->save(); 
          
 
 
        } catch (\Exception $e){
            DB::rollBack();
        }
 
    }

    public function desactivar(Request $request)
    {
        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->estado = 'inactivo';
        $estudiante->save();
    }

    public function activar(Request $request)
    {
        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->condicion = '1';
        $estudiante->save();
    }

    public function destroy(Request $request)
    {
        $estudiante = Estudiante::findOrFail($request->id);
     
        $estudiante->delete();
    }
    public function exportarEstudiantes()
    {
       
        return Excel::download(new EstudiantesExport, 'Estudiantes.xlsx');
    
    }

    public function importarEstudiantes(Request $request)
{
   /** validamos si existe nuesto archivo */  
    if (!$request->hasFile('file')) {
        return ('archivo no encotrado');
    }       
    try {
        $file = $request->file('file');
        Excel::import(new EstudiantesImport, $file);
        return ( 'exito');
      } catch (\Exception $e) {
              return $e;
      }

    
   
 
}

}
