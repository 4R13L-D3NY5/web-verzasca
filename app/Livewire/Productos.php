<?php

namespace App\Livewire;

use App\Models\Producto;
use App\Models\Base;
use App\Models\Tapa;
use Livewire\Component;
use Livewire\WithFileUploads;

class Productos extends Component
{
    use WithFileUploads;

    public $productos, $nombre, $imagen, $tipoContenido, $tipoProducto, $capacidad, $precioReferencia, $observaciones, $estado = 1, $base_id, $tapa_id;
    public $producto_id;
    public $modal = false;

    public function render()
    {
        $this->productos = Producto::all();
        $bases = Base::all();
        $tapas = Tapa::all();
        return view('livewire.productos', compact('bases', 'tapas'));
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
        $this->producto_id = null;
        $this->nombre = '';
        $this->imagen = null;
        $this->tipoContenido = '';
        $this->tipoProducto = '';
        $this->capacidad = '';
        $this->precioReferencia = '';
        $this->observaciones = '';
        $this->estado = 1;
        $this->base_id = '';
        $this->tapa_id = '';
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
            'tipoContenido' => 'required|integer',
            'tipoProducto' => 'required|boolean',
            'capacidad' => 'required|integer',
            'precioReferencia' => 'required|numeric',
            'estado' => 'required|boolean',
            'base_id' => 'required|exists:bases,id',
            'tapa_id' => 'nullable|exists:tapas,id',
        ]);

        // Manejar imagen
        if ($this->imagen) {
            $imagenPath = $this->imagen->store('productos', 'public');
        } else {
            $imagenPath = null;
        }

        Producto::updateOrCreate(['id' => $this->producto_id], [
            'nombre' => $this->nombre,
            'imagen' => $imagenPath,
            'tipoContenido' => $this->tipoContenido,
            'tipoProducto' => $this->tipoProducto,
            'capacidad' => $this->capacidad,
            'precioReferencia' => $this->precioReferencia,
            'observaciones' => $this->observaciones,
            'estado' => $this->estado,
            'base_id' => $this->base_id,
            'tapa_id' => $this->tapa_id,
        ]);

        session()->flash('message', $this->producto_id ? 'Producto actualizado' : 'Producto creado');

        $this->cerrarModal();
    }

    public function editar($id)
    {
        $producto = Producto::findOrFail($id);
        $this->producto_id = $id;
        $this->nombre = $producto->nombre;
        $this->imagen = $producto->imagen;
        $this->tipoContenido = $producto->tipoContenido;
        $this->tipoProducto = $producto->tipoProducto;
        $this->capacidad = $producto->capacidad;
        $this->precioReferencia = $producto->precioReferencia;
        $this->observaciones = $producto->observaciones;
        $this->estado = $producto->estado;
        $this->base_id = $producto->base_id;
        $this->tapa_id = $producto->tapa_id;

        $this->modal = true;
    }
}
