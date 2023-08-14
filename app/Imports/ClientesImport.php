<?php

namespace App\Imports;

use App\Models\Persona;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
class ClientesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;
    public function model(array $row)
    {
        return new Persona([
                'nombre' => $row['nombre'] ?? null,
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
