<?php

namespace App\Livewire;

use App\Models\Tapa;
use Livewire\Component;

class Tapas extends Component
{
    public $tapas, $color, $tipo, $cantidad, $tapa_id;
    public $modal = false;

    public function render()
    {
        $this->tapas = Tapa::all();
        return view('livewire.tapas');
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
        $this->tapa_id = null;
        $this->color = '';
        $this->tipo = '';
        $this->cantidad = '';
    }

    public function guardar()
    {
        $this->validate([
            'color' => 'required|string',
            'tipo' => 'required|string',
            'cantidad' => 'required|integer', // Validación para cantidad
        ]);

        // Crear o actualizar la tapa
        Tapa::updateOrCreate(
            ['id' => $this->tapa_id], // Si existe un id, lo actualizará, si no, lo creará
            [
                'color' => $this->color,
                'tipo' => $this->tipo,
                'cantidad' => $this->cantidad,
            ]
        );

        session()->flash('message', $this->tapa_id ? 'Tapa actualizada exitosamente' : 'Tapa creada exitosamente');
        
        $this->cerrarModal();
    }

    public function editar($id)
    {
        // Obtener la tapa que se desea editar
        $tapa = Tapa::findOrFail($id);

        // Asignar los valores del modelo a las propiedades del componente
        $this->tapa_id = $id;
        $this->color = $tapa->color;
        $this->tipo = $tapa->tipo;
        $this->cantidad = $tapa->cantidad;

        // Abrir el modal para editar
        $this->modal = true;
    }
}
