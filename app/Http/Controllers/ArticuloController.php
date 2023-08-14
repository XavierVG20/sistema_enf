<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use DataTables;
use Cloudinary;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Media;
use App\Http\Requests\ArticuloRequest;
use App\Exports\ArticulosExport;
use App\Imports\ArticulosImport;



/**
 * autor: Javier Velasque
 * Controlador articulos
 */
class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * obtenemos los datos de la tabla articulos 
     */
    public function index(Request $request)
    {
       if (!$request->ajax()) return view('articulo');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
      
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->leftjoin('media', 'articulos.idmedia', '=', 'media.id' )
            ->select('articulos.id', 'articulos.idmedia','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion','media.public_id','media.file_url','media.file_name')
            ->orderBy('articulos.id', 'desc')->paginate(5);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->leftjoin('media', 'articulos.idmedia', '=', 'media.id' )
            ->select('articulos.id', 'articulos.idmedia','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion','media.public_id','media.file_url','media.file_name')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(5);
        }
        
//devolvemos los datos mediante una arreglo de paginas 
        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }

    /**
     * creamos un listado  de tods los articulos
     */
    public function listarArticulo(Request $request)
    {
       

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return ['articulos' => $articulos];
    }

    public function listarArticuloVenta(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);

        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);

          
        }
        

        return ['articulos' => $articulos];
    }
    
    /**
     * funcion para crear nuestro pdf con el total de los articulos
     */
    public function listarPdf()
    {

        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
        ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
        ->orderBy('articulos.nombre', 'desc')->get();

        $cont=Articulo::count();
//redireccionamos lod datos a nustro archivo articulospdf.php
        $pdf = \PDF::loadView('pdf.articulospdf',['articulos'=>$articulos,'cont'=>$cont]);
        return $pdf->download('articulos.pdf');
    }

    public function buscarArticulo(Request $request )
    {

        $filtro = $request->filtro;
        if($filtro== ''){
           
            $articulos = Articulo::orderBy('nombre', 'asc');
        }else{
            $articulos = Articulo::where('codigo','=', $filtro)
            ->select('id', 'nombre')->orderBy('nombre', 'asc')->take(1)->get();
    
        }
        
        return ['articulos' => $articulos];
    }

    public function buscarArticuloVenta(Request $request )
    {

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id', 'nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')->take(1)->get();

        return ['articulos' => $articulos];
    }
/**
 * creamos nuestra funcion para crear un nuevo articulo 
 */
    public function store(ArticuloRequest $request)
    { 
        /**
         * compromoas si existe una imagen para guardarlo 
         */
        if ($request->hasFile('file')) {
            # cloudynary 

            $result = $request->file->storeOnCloudinary('articulos');
 
            $media = new Media();
           // $media->idmedia = $request->id;
            $media->public_id = $result->getPublicId();
            $media->file_url =  $result->getSecurePath();
            $media->file_name = $result->getFileName();
            $media->file_type = $result->getFileType();
            $media->size = $result->getSize();
                       
            $media->save();

            $articulo = new Articulo();
            $articulo->idcategoria = $request->idcategoria;
            $articulo->codigo = $request->codigo;
            $articulo->nombre = $request->nombre;
            $articulo->precio_venta = $request->precio_venta;
            $articulo->stock = $request->stock;
            $articulo->descripcion = $request->descripcion;
            $articulo->condicion = '1';
            $articulo->idmedia =  $media->id;
            $articulo->save();
            return 'existe fto';
        } else {
            $articulo = new Articulo();
            $articulo->idcategoria = $request->idcategoria;
            $articulo->codigo = $request->codigo;
            $articulo->nombre = $request->nombre;
            $articulo->precio_venta = $request->precio_venta;
            $articulo->stock = $request->stock;
            $articulo->descripcion = $request->descripcion;
            $articulo->condicion = '1';
            $articulo->save();
            return 'no fto';

        }
        
        
        


    }

    /** 
     * funcion para actualizar el articulo
     */
    public function update(Request $request)
    {
    
        if ($request->hasFile('file')) {
            # cludynary 
            if($request->public_id){
                $result = $request->file->storeOnCloudinary('articulos');
                $media = new Media();
           // $media->idmedia = $request->id;
            $media->public_id = $result->getPublicId();
            $media->file_url =  $result->getSecurePath();
            $media->file_name = $result->getFileName();
            $media->file_type = $result->getFileType();
            $media->size = $result->getSize();
                       
            $media->save();
    
                $articulo = Articulo::findOrFail($request->id);
                $articulo->idcategoria = $request->idcategoria;
                $articulo->codigo = $request->codigo;
                $articulo->nombre = $request->nombre;
                $articulo->precio_venta = $request->precio_venta;
                $articulo->stock = $request->stock;
                $articulo->descripcion = $request->descripcion;
                $articulo->condicion = '1';
                $articulo->idmedia =  $media->id;
                $articulo->save();
            

            }else{
                $result = $request->file->storeOnCloudinary('articulos');
                Cloudinary::destroy($request->public_id);

                $media =  Media::findOrFail($request->idmedia);
               // $media->idmedia = $request->id;
                $media->public_id = $result->getPublicId();
                $media->file_url =  $result->getSecurePath();
                $media->file_name = $result->getFileName();
                $media->file_type = $result->getFileType();
                $media->size = $result->getSize();
                           
                $media->save();
    
                $articulo = Articulo::findOrFail($request->id);
                $articulo->idcategoria = $request->idcategoria;
                $articulo->codigo = $request->codigo;
                $articulo->nombre = $request->nombre;
                $articulo->precio_venta = $request->precio_venta;
                $articulo->stock = $request->stock;
                $articulo->descripcion = $request->descripcion;
                $articulo->condicion = '1';
                $articulo->idmedia =  $media->id;
                $articulo->save();
            
            }
 
               
            return 'existe fto';
        } else {
                   
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria  = $request->idcategoria ;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
        
            return 'no fto';

        }

      //  return $request;
    }

    /**
     * funcios para obtener los articulos mas comprados 
     */
    public function ArticulosVendidos()
    {
        # corregir
      

        $articulo = Articulo::join('detalle_ventas', 'articulos.id', '=','detalle_ventas.idarticulo')
        ->leftjoin('media', 'articulos.idmedia', '=', 'media.id' )
        ->select('*' ,'count(detalle_ventas.cantidad) as total')
        
        ->paginate(10);
        return['articulos'=>$articulo];
    }
public function exportarArticulo()
{
    /*
    $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
    ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
    ->orderBy('articulos.nombre', 'desc')->get();
    Excel::create('$articulos',function ($excel) use ($articulos)
    {
        $excel->sheet('exportar', function ($sheet) use ($articulos)
        {
            $sheet->fro mArray($articulos);
        });

    })->export('xls');

    return back();
    */

  //  Excel::download()
    return Excel::download(new ArticulosExport, 'products.xlsx');

}
public function importarArticulos(Request $request)
{
   /** validamos si existe nuesto archivo */

  
    if (!$request->hasFile('file')) {
        return ('archivo no encotrado');
    }
   
   
        
    try {
        $file = $request->file('file');

        Excel::import(new ArticulosImport, $file);
    
        return ( 'Productos importados exitosamente');
      } catch (\Exception $e) {
              return $e;
      }

    
   
 
}
    /**
     * funciones para activar o desactivar los articulos
     * */
    public function desactivar(Request $request)
    {
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }

    public function activar(Request $request)
    {
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }
    public function destroy(Request $request)
    {
        $articulo = Articulo::findOrFail($request->id);
     
        $articulo->delete();
    }
}
