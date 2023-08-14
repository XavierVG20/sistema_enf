<?php

namespace App\Exports;

use App\Models\Insumo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class InsumosExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Insumo::all();
    }

    public function headings (): array
    {
        return [ 
            'Id',
            'Nombre',
            'Descripcion',
            'Unidad',
         
        ];
    }
}
