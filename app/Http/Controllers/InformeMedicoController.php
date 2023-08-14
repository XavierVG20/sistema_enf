<?php

namespace App\Http\Controllers;

use App\Models\Detalle_medico;
use App\Models\Estudiante;
use App\Models\Informe_medico;
use App\Models\Insumo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InformeMedicoController extends Controller
{
 //   public function __construct()
   // {
     //   $this->middleware('auth');
   // }

    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('informe_medico');
        }

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $informe_medicos = Estudiante::join('informe_medicos', 'informe_medicos.idestudiante', '=', 'estudiantes.id')
                ->join('users', 'informe_medicos.idusuario', '=', 'users.id')
                ->select('informe_medicos.id', 'informe_medicos.created_at', 'informe_medicos.motivo_emergencia', 'informe_medicos.fecha_hora',  'estudiantes.nombre', 'estudiantes.num_documento', 'estudiantes.curso', 'users.name')
                ->orderBy('informe_medicos.id', 'desc')->paginate(5);
        } else {
            $informe_medicos = Estudiante::
                join('informe_medicos', 'informe_medicos.idestudiante', '=', 'estudiantes.id')
                ->join('users', 'informe_medicos.idusuario', '=', 'users.id')
                ->select('informe_medicos.id', 'informe_medicos.motivo_emergencia', 'informe_medicos.fecha_hora',  'estudiantes.nombre', 'estudiantes.num_documento', 'estudiantes.curso', 'users.name')
                
                ->where( $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('informe_medicos.id', 'desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total' => $informe_medicos->total(),
                'current_page' => $informe_medicos->currentPage(),
                'per_page' => $informe_medicos->perPage(),
                'last_page' => $informe_medicos->lastPage(),
                'from' => $informe_medicos->firstItem(),
                'to' => $informe_medicos->lastItem(),
            ],
            'informe_medicos' => $informe_medicos,
        ];
    }
    public function obtenerCabecera(Request $request)
    {
        if (!$request->ajax()) {
          //  return redirect('/');
        }

        $id = $request->id;
        $informe_medicos = Informe_medico::join('estudiantes', 'informe_medicos.idestudiante', '=', 'estudiantes.id')
        ->join('users', 'informe_medicos.idusuario', '=', 'users.id')
        ->select('informe_medicos.id', 'informe_medicos.motivo_emergencia', 'informe_medicos.fecha_hora',  'estudiantes.nombre', 'estudiantes.curso','estudiantes.num_documento','estudiantes.direccion',
        'estudiantes.rep_nombre','estudiantes.rep_documento','estudiantes.telefono', 'users.name')
        ->where('informe_medicos.id', '=', $id)
        ->orderBy('informe_medicos.id', 'desc')->get();

        return ['informe_medicos' =>$informe_medicos];
    }

    public function obtenerDetalles(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $id = $request->id;
        $detalles = Detalle_medico::join('insumos', 'detalle_medicos.idinsumo', '=', 'insumos.id')
            ->select('detalle_medicos.cantidad', 'insumos.nombre')
            ->where('detalle_medicos.idinforme_medico', '=', $id)
            ->orderBy('detalle_medicos.id', 'desc')->get();

        return ['detalles' => $detalles];
    }
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $mytime = Carbon::now();

            $informe_medico = new Informe_medico();
            $informe_medico->idestudiante = $request->idestudiante;
            $informe_medico->idusuario = \Auth::user()->id;
          
            $informe_medico->fecha_hora = $mytime->toDateString();
            $informe_medico->motivo_emergencia = $request->motivo_emergencia;
            $informe_medico->save();

            $detalles = $request->data; //Array de detalles
            //Recorro todos los elementos

            foreach ($detalles as $ep => $det) {
                $detalle = new Detalle_medico();
                $detalle->idinforme_medico = $informe_medico->id;
                $detalle->idinsumo= $det['idinsumo'];
                $detalle->cantidad = $det['unidad'];
                $detalle->save();

                $insumo = Insumo::findOrFail($det['idinsumo']);
            $insumo->unidad = $insumo->unidad -  $det['unidad'] ;
            $insumo->save();
            }

            DB::commit();
            return [
                'id' => $informe_medico->id,
            ];
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
    public function pdf(Request $request, $id)
    {
        $id = $request->id;
        $informe_medicos = Informe_medico::join('estudiantes', 'informe_medicos.idestudiante', '=', 'estudiantes.id')
        ->join('users', 'informe_medicos.idusuario', '=', 'users.id')
        ->select('informe_medicos.id', 'informe_medicos.motivo_emergencia', 'informe_medicos.fecha_hora',  'estudiantes.nombre', 'estudiantes.curso','estudiantes.num_documento','estudiantes.direccion',
        'estudiantes.rep_nombre','estudiantes.rep_documento','estudiantes.telefono', 'users.name')
        ->where('informe_medicos.id', '=', $id)
        ->orderBy('informe_medicos.id', 'desc')->get();

        


        $detalles = Detalle_medico::join('insumos', 'detalle_medicos.idinsumo', '=', 'insumos.id')
        ->select('detalle_medicos.cantidad', 'insumos.nombre', 'insumos.descripcion')
        ->where('detalle_medicos.idinforme_medico', '=', $id)
        ->orderBy('detalle_medicos.id', 'desc')->get();

        $pdf = \PDF::loadView('pdf.reporte_venta', ['informe_medicos' => $informe_medicos, 'detalles' => $detalles]);
        return $pdf->download('informe_medico.pdf');

    }

    public function listarPdf(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $informe_medicos = Estudiante::join('informe_medicos', 'informe_medicos.idestudiante', '=', 'estudiantes.id')
                ->join('users', 'informe_medicos.idusuario', '=', 'users.id')
                ->select('informe_medicos.id', 'informe_medicos.motivo_emergencia', 'informe_medicos.fecha_hora', 'informe_medicos.created_at',  'estudiantes.nombre', 'estudiantes.curso', 'users.name as encargado')
                ->orderBy('informe_medicos.id', 'desc')->get();
        } else {
            $informe_medicos = Estudiante::
                join('informe_medicos', 'informe_medicos.idestudiante', '=', 'estudiantes.id')
                ->join('users', 'informe_medicos.idusuario', '=', 'users.id')
                ->select('informe_medicos.id', 'informe_medicos.motivo_emergencia', 'informe_medicos.fecha_hora',  'estudiantes.nombre', 'estudiantes.curso', 'users.name as encargado')
                
                ->where( 'estudiantes.'.$criterio, 'like', '%' . $buscar . '%')
                ->orderBy('informe_medicos.id', 'desc')->get();
        }

        $cont=Informe_medico::count();
//redireccionamos lod datos a nustro archivo articulospdf.php
        $pdf = \PDF::loadView('pdf.articulospdf',['informe_medicos'=>$informe_medicos,'cont'=>$cont]);
        return $pdf->download('informes_medicos.pdf');
    }

}
