<?php

namespace App\Livewire;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Productos extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $modal = false;
    public $producto_id = null;
    public $nombre = '';
    public $imagen = null;
    public $tipoContenido = '';
    public $tipoProducto = '';
    public $capacidad = '';
    public $precioReferencia = '';
    public $observaciones = '';
    public $estado = 1;
    public $accion = 'create';
    public $productoSeleccionado = [];
    public $modalDetalle = false;
    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'nombre' => 'required|string',
        'capacidad' => 'required|integer',
        'precioReferencia' => 'required|numeric',
        'estado' => 'required|boolean',
    ];

    public function render()
    {
        $productos = Producto::when($this->search, function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })->paginate(4);

        return view('livewire.productos', compact('productos'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        $this->reset(['nombre', 'imagen', 'tipoContenido', 'tipoProducto', 'capacidad', 'precioReferencia', 'observaciones', 'estado']);
        $this->accion = $accion;
        if ($accion === 'edit' && $id) {
            $this->editar($id);
        }
        $this->modal = true;
    }

    public function editar($id)
    {
        $producto = Producto::findOrFail($id);
        $this->producto_id = $producto->id;
        $this->nombre = $producto->nombre;
        $this->imagen = $producto->imagen;
        $this->tipoContenido = $producto->tipoContenido;
        $this->tipoProducto = $producto->tipoProducto;
        $this->capacidad = $producto->capacidad;
        $this->precioReferencia = $producto->precioReferencia;
        $this->observaciones = $producto->observaciones;
        $this->estado = $producto->estado;
        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate();

        try {
            $imagenPath = $this->imagen ? $this->imagen->store('productos', 'public') : null;

            Producto::updateOrCreate(['id' => $this->producto_id], [
                'nombre' => $this->nombre,
                'imagen' => $imagenPath,
                'tipoContenido' => $this->tipoContenido,
                'tipoProducto' => $this->tipoProducto,
                'capacidad' => $this->capacidad,
                'precioReferencia' => $this->precioReferencia,
                'observaciones' => $this->observaciones,
                'estado' => $this->estado,
            ]);

            LivewireAlert::title($this->producto_id ? 'Producto actualizado con éxito.' : 'Producto creado con éxito.')
                ->success()
                ->show();

            $this->cerrarModal();
        } catch (\Exception $e) {
            LivewireAlert::title('Ocurrió un error: ' . $e->getMessage())
                ->error()
                ->show();
        }
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->reset(['nombre', 'imagen', 'tipoContenido', 'tipoProducto', 'capacidad', 'precioReferencia', 'observaciones', 'estado', 'producto_id']);
        $this->resetErrorBag();
    }

    public function modaldetalle($id)
    {
        $this->productoSeleccionado = Producto::findOrFail($id);
        $this->modalDetalle = true;
    }

    public function cerrarModalDetalle()
    {
        $this->modalDetalle = false;
        $this->productoSeleccionado = null;
    }
}
