<?php

namespace App\Imports;

use App\Models\Insumo;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;



class InsumosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param Collection $collection
    */
    use Importable;

     public function model(array $row)
    {
        return new Insumo(
            [
                'nombre' => $row['nombre']?? null,
                'descripcion' => $row['descripcion']?? null, 
                'unidad' => $row['unidad']?? null, 
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
