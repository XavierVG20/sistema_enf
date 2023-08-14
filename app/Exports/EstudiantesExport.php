<?php

namespace App\Exports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EstudiantesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Estudiante::all();
    }
    public function headings (): array
    {
        return [ 
            'Id',
            'Nombre',
            'Curso',
            'CI',
            'Direccion',
            'Representante',
            'CI_Representante',
            'Telefono',
         
        ];
    }
}

