<?php

namespace App\Http\Controllers;

use App\Exports\InsumosExport;
use App\Http\Requests\InsumoRequest;
use App\Imports\InsumosImport;
use App\Models\Insumo;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */
    //

    public function index(Request $request)
    {
       if (!$request->ajax()) return view('insumo');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
      
        if ($buscar==''){
            $insumos = Insumo::orderBy('id', 'desc')->paginate(5);
        }
        else{
            $insumos = Insumo::select('*')
            ->where('insumos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(5);
        }
        
//devolvemos los datos mediante una arreglo de paginas 
        return [
            'pagination' => [
                'total'        => $insumos->total(),
                'current_page' => $insumos->currentPage(),
                'per_page'     => $insumos->perPage(),
                'last_page'    => $insumos->lastPage(),
                'from'         => $insumos->firstItem(),
                'to'           => $insumos->lastItem(),
            ],
            'insumos' => $insumos
        ];
    }

    public function listarInsumos(Request $request)
    {
       

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $insumos = Insumo::orderBy('id', 'desc')->paginate(5);
        }
        else{
            $insumos = Insumo::select('*')
            ->where('insumos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('insumos.id', 'desc')->paginate(5);
        }
        

        return ['insumos' => $insumos];
    }

    public function listarInsumosInforme(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $insumos = Insumo::select('*')
            ->where('insumos.unidad','>','0')
            ->orderBy('insumos.id', 'desc')->paginate(10);

        }
        else{
            $insumos = Insumo::select('*')
            ->where('insumos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('insumos.unidad','>','0')
            ->orderBy('insumos.id', 'desc')->paginate(10);

          
        }
        

        return ['insumos' => $insumos];
    }

    public function buscarInsumo(Request $request )
    {

        $buscar = $request->buscar;
        $criterio = $request->criterio;
      
        if ($buscar==''){
            $insumos = Insumo::orderBy('id', 'desc')->paginate(5);
        }
        else{
            $insumos = Insumo::select('*')
            ->where('insumos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('insumos.id', 'desc')->paginate(5);
        }
        
        return ['insumos' => $insumos];
    }

    public function store(InsumoRequest $request)
    {       
            $insumo = new Insumo();
            $insumo->nombre = $request->nombre;
            $insumo->descripcion = $request->descripcion;
            $insumo->unidad = $request->unidad;
            $insumo->condicion = '1';
            $insumo->save();
    }

    public function update(Request $request)
    {       
            $insumo = Insumo::findOrFail($request->id);
            $insumo->nombre = $request->nombre;
            $insumo->descripcion = $request->descripcion;
            $insumo->unidad = $request->unidad;
            $insumo->condicion = '1';
            $insumo->save();
    }
    public function exportarInsumos()
    {
       
        return Excel::download(new InsumosExport, 'insumos.xlsx');
    
    }

    public function importarInsumos(Request $request)
{
   /** validamos si existe nuesto archivo */  
    if (!$request->hasFile('file')) {
        return ('archivo no encotrado');
    }       
    try {
        $file = $request->file('file');
        Excel::import(new InsumosImport, $file);
        return ( 'exito');
      } catch (\Exception $e) {
              return $e;
      }

    
   
 
}
    public function desactivar(Request $request)
    {
        $insumo = Insumo::findOrFail($request->id);
        $insumo->condicion = '0';
        $insumo->save();
    }

    public function activar(Request $request)
    {
        $insumo = Insumo::findOrFail($request->id);
        $insumo->condicion = '1';
        $insumo->save();
    }

    public function destroy(Request $request)
    {
        $insumo = Insumo::findOrFail($request->id);
     
        $insumo->delete();
    }

}
