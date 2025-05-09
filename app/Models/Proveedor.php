<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'razonSocial',
        'nombreContacto',
        'direccion',
        'telefono',
        'correo',
        'tipo',
        'servicio',
        'descripcion',
        'precio',
        'tiempoEntrega',
        'estado',
    ];
}
