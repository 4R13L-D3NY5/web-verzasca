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
    public $modalDetalle = false;

    public $producto_id = null;
    public $nombre = '';
    public $imagen = null;
    public $tipoContenido = '';
    public $tipoProducto = '';
    public $capacidad = '';
    public $unidad = 'ml';
    public $precioReferencia = '';
    public $precioReferencia2 = '';
    public $precioReferencia3 = '';
    public $observaciones = '';
    public $estado = 1;
    public $accion = 'create';
    public $productoSeleccionado = [];

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:0',
            'unidad' => 'required|string|max:10',
            'tipoContenido' => 'required|integer|between:0,255', 
            'tipoProducto' => 'nullable|boolean',
            'precioReferencia' => 'required|numeric|min:0',
            'precioReferencia2' => 'nullable|numeric|min:0',
            'precioReferencia3' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',
            'estado' => 'required|boolean',
        ];

        if ($this->accion === 'create' || ($this->imagen instanceof \Livewire\TemporaryUploadedFile)) {
            $rules['imagen'] = 'nullable|image|max:2048';
        }

        return $rules;
    }

    public function render()
    {
        $productos = Producto::when($this->search, function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })->orderByDesc('id')->paginate(4);

        return view('livewire.productos', compact('productos'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        $this->reset([
            'producto_id', 'nombre', 'imagen', 'tipoContenido', 'tipoProducto', 'capacidad',
            'unidad', 'precioReferencia', 'precioReferencia2', 'precioReferencia3',
            'observaciones', 'estado'
        ]);

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
        $this->tipoContenido = $producto->tipoContenido;
        $this->tipoProducto = $producto->tipoProducto;
        $this->capacidad = $producto->capacidad;
        $this->unidad = $producto->unidad;
        $this->precioReferencia = $producto->precioReferencia;
        $this->precioReferencia2 = $producto->precioReferencia2;
        $this->precioReferencia3 = $producto->precioReferencia3;
        $this->observaciones = $producto->observaciones;
        $this->estado = $producto->estado;
        $this->imagen = $producto->imagen;

        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate();

        try {
            $producto = $this->producto_id ? Producto::findOrFail($this->producto_id) : new Producto();

            if ($this->imagen instanceof \Livewire\TemporaryUploadedFile) {
                $imagenPath = $this->imagen->store('productos', 'public');
                $producto->imagen = $imagenPath;
            }

            $producto->nombre = $this->nombre;
            $producto->tipoContenido = $this->tipoContenido;
            $producto->tipoProducto = $this->tipoProducto;
            $producto->capacidad = $this->capacidad;
            $producto->unidad = $this->unidad;
            $producto->precioReferencia = $this->precioReferencia;
            $producto->precioReferencia2 = $this->precioReferencia2;
            $producto->precioReferencia3 = $this->precioReferencia3;
            $producto->observaciones = $this->observaciones;
            $producto->estado = $this->estado;

            $producto->save();

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
        $this->reset([
            'producto_id', 'nombre', 'imagen', 'tipoContenido', 'tipoProducto', 'capacidad',
            'unidad', 'precioReferencia', 'precioReferencia2', 'precioReferencia3',
            'observaciones', 'estado'
        ]);
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
