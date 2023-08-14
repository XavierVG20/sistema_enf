<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $fillable = [
    'nombre',
    'curso',
    'num_documento',
    'direccion',
    'rep_nombre',
    'rep_documento',
    'telefono',
    'estado'];
}
