<?php

namespace App\Livewire;

use App\Models\Etiqueta;
use App\Models\Cliente;  // Importa el modelo Cliente
use Livewire\Component;

class Etiquetas extends Component
{
    public $etiquetas, $imagen, $capacidad, $estado = 1, $cliente_id, $observaciones;
    public $etiqueta_id;
    public $modal = false;
    public $clientes; // Agrega la propiedad clientes

    public function mount()
    {
        // Cargar los clientes cuando el componente es inicializado
        $this->clientes = Cliente::all();
    }

    public function render()
    {
        // Obtener todas las etiquetas
        $this->etiquetas = Etiqueta::all();
        return view('livewire.etiquetas');
    }

    // Abrir el modal para crear o editar
    public function abrirModal()
    {
        $this->limpiarCampos();
        $this->modal = true;
    }

    // Cerrar el modal
    public function cerrarModal()
    {
        $this->modal = false;
    }

    // Limpiar los campos del formulario
    public function limpiarCampos()
    {
        $this->etiqueta_id = null;
        $this->imagen = '';
        $this->capacidad = '';
        $this->estado = 1;
        $this->cliente_id = null;
        $this->observaciones = '';
    }

    // Guardar la etiqueta (crear o actualizar)
    public function guardar()
    {
        $this->validate([
            'imagen' => 'required|string',
            'capacidad' => 'required|string',
            'estado' => 'required|boolean',
        ]);

        // Crear o actualizar la etiqueta
        Etiqueta::updateOrCreate(['id' => $this->etiqueta_id], [
            'imagen' => $this->imagen,
            'capacidad' => $this->capacidad,
            'estado' => $this->estado,
            'cliente_id' => $this->cliente_id,
            'observaciones' => $this->observaciones,
        ]);

        session()->flash('message', $this->etiqueta_id ? 'Etiqueta actualizada' : 'Etiqueta creada');

        $this->cerrarModal();
    }

    // Función para editar una etiqueta
    public function editar($id)
    {
        $etiqueta = Etiqueta::findOrFail($id);
        $this->etiqueta_id = $id;
        $this->imagen = $etiqueta->imagen;
        $this->capacidad = $etiqueta->capacidad;
        $this->estado = $etiqueta->estado;
        $this->cliente_id = $etiqueta->cliente_id;
        $this->observaciones = $etiqueta->observaciones;

        $this->modal = true;
    }
}
