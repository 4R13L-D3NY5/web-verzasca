<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Base;
use App\Models\Preforma;

class Bases extends Component
{
    public $bases, $preformas, $base_id, $cantidad, $capacidad, $estado = 1, $observaciones, $preforma_id;
    public $modal = false;

    public function render()
    {
        $this->bases = Base::with('preforma')->get();
        $this->preformas = Preforma::all();
        return view('livewire.bases');
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
        $this->base_id = null;
        $this->cantidad = '';
        $this->capacidad = '';
        $this->estado = 1;
        $this->observaciones = '';
        $this->preforma_id = '';
    }

    public function guardar()
    {
        $this->validate([
            'cantidad' => 'required|integer|min:1',
            'capacidad' => 'required|integer|min:1',
            'estado' => 'required|boolean',
            'observaciones' => 'nullable|string',
            'preforma_id' => 'nullable|exists:preformas,id',
        ]);

        Base::updateOrCreate(['id' => $this->base_id], [
            'cantidad' => $this->cantidad,
            'capacidad' => $this->capacidad,
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,
            'preforma_id' => $this->preforma_id,
        ]);

        session()->flash('message', $this->base_id ? 'Base actualizada' : 'Base creada');

        $this->cerrarModal();
    }

    public function editar($id)
    {
        $base = Base::findOrFail($id);
        $this->base_id = $id;
        $this->cantidad = $base->cantidad;
        $this->capacidad = $base->capacidad;
        $this->estado = $base->estado;
        $this->observaciones = $base->observaciones;
        $this->preforma_id = $base->preforma_id;

        $this->modal = true;
    }
}
