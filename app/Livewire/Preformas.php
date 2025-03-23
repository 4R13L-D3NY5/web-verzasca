<?php

namespace App\Livewire;

use App\Models\Preforma;
use Livewire\Component;

class Preformas extends Component
{
    public $preformas, $insumo, $descripcion, $capacidad, $color, $cantidad, $estado = 1, $observaciones;
    public $preforma_id;
    public $modal = false;

    public function render()
    {
        $this->preformas = Preforma::all();
        return view('livewire.preformas');
    }

    public function abrirModal()
    {
        $this->limpiarCampos();
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function limpiarCampos()
    {
        $this->preforma_id = null;
        $this->insumo = '';
        $this->descripcion = '';
        $this->capacidad = '';
        $this->color = '';
        $this->cantidad = '';
        $this->estado = 1;
        $this->observaciones = '';
    }

    public function guardar()
    {
        $this->validate([
            'insumo' => 'required|string',
            'capacidad' => 'required|integer',
            'color' => 'required|string',
            'cantidad' => 'required|integer',
            'estado' => 'required|boolean',
        ]);

        Preforma::updateOrCreate(['id' => $this->preforma_id], [
            'insumo' => $this->insumo,
            'descripcion' => $this->descripcion,
            'capacidad' => $this->capacidad,
            'color' => $this->color,
            'cantidad' => $this->cantidad,
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,
        ]);

        session()->flash('message', $this->preforma_id ? 'Preforma actualizada' : 'Preforma creada');

        $this->cerrarModal();
    }

    public function editar($id)
    {
        $preforma = Preforma::findOrFail($id);
        $this->preforma_id = $id;
        $this->insumo = $preforma->insumo;
        $this->descripcion = $preforma->descripcion;
        $this->capacidad = $preforma->capacidad;
        $this->color = $preforma->color;
        $this->cantidad = $preforma->cantidad;
        $this->estado = $preforma->estado;
        $this->observaciones = $preforma->observaciones;

        $this->modal = true;
    }
}
