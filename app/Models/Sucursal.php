<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'zona',
        'empresa_id',
    ];

    /**
     * Relación: Una sucursal pertenece a una empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relación 1:N con Stock.
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
