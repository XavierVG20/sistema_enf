<?php

namespace App\Imports;

use App\Models\Articulo;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;



class ArticulosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

use Importable;
    public function model(array $row)
    {
        return new Articulo(
            [
                'idcategoria' => $row['categoria']?? null,
                'codigo' => $row['codigo']?? null, 
                'nombre' => $row['nombre']?? null, 
                'precio_venta' => $row['precio']?? null, 
                'stock' => $row['stock']?? null, 
                'descripcion' => $row['descripcion']?? null, 
                'condicion' => '1'
            ]
            );
       
    }

    /**
     * Permite especificar un tamaño del lote
     */
    public function batchSize(): int
    {
        return 4000;
    }

    /**
     * nos permite leer el archivo en trozos
     */
   

    public function chunkSize(): int
    {
        return 4000;
    }
}

