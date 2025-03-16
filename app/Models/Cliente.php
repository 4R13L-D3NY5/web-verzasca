<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'empresa',
        'nitCi',
        'razonSocial',
        'telefono',
        'celular',
        'correo',
        'latitud',
        'longitud',
        'foto',
        'estado',
    ];

    /**
     * Relación 1:N con Venta.
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}

