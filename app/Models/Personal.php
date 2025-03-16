<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos',
        'direccion',
        'celular',
        'estado',
        'usuario_id',
    ];

    /**
     * Relación con el modelo Usuario (nullable).
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relación 1:N con Asignacion.
     */
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    /**
     * Relación 1:N con Venta.
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    /**
     * Relación 1:N con Enbotellado.
     */
    public function enbotellados()
    {
        return $this->hasMany(Embotellado::class);
    }

    /**
     * Relación 1:N con Elaboracion.
     */
    public function elaboraciones()
    {
        return $this->hasMany(Elaboracion::class);
    }

    /**
     * Relación 1:N con Compra.
     */
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
