<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
class EstudiantesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param Collection $collection
    */

    use Importable;
    public function model(array $row)
    {
        return new Estudiante(
            [
                'nombre' => $row['nombre']?? null,
                'curso' => $row['curso']?? null, 
                'num_documento' => $row['ci']?? null, 
                'direccion' => $row['direccion']?? null, 
                'rep_nombre' => $row['representante']?? null, 
                'rep_documento' => $row['ci_representante']?? null, 
                'telefono' => $row['telefono']?? null, 
                'estado' => 'Activo'
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
