<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe_medico extends Model
{
    use HasFactory;
    protected $fillable = [
        'idestudiante', 
        'idusuario',
        'motivo_emergencia',
        'fecha_hora',
       
    ];
}
