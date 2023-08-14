<?php

namespace App\Imports;

use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProveedoresImport implements ToModel,  WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Proveedor([
            'contacto' => $row['contacto']?? null,
            'telefono_contacto' => $row['telefono_contacto']?? null, 
                'nombre' => $row['proveedor'] ?? null,
                'tipo_documento'=> $row['tipo_documento']?? null, 
                'num_documento' => $row['numero_documento']?? null, 
                'direccion' => $row['direccion']?? null, 
                'telefono' => $row['telefono']?? null, 
                'email' => $row['email']?? null,
              
 
        ]);
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
