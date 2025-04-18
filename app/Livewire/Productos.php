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
    public $imagen;
    public $tipoContenido = '';
    public $tipoProducto = '';
    public $capacidad = '';
    public $unidad = 'ml';
    public $precioReferencia = '';
    public $precioReferencia2 = '';
    public $precioReferencia3 = '';
    public $observaciones = '';
    public $estado = 1;
    public $base_id = null; // Nuevo campo base_id
    public $accion = 'create';
    public $productoSeleccionado = [];

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'imagen' => 'nullable|image|max:1024',
        'nombre' => 'required|string|max:255',
        'tipoContenido' => 'required|integer|between:0,255',
        'tipoProducto' => 'nullable|boolean',
        'capacidad' => 'required|integer|min:0',
        'unidad' => 'required|string|max:10',
        'precioReferencia' => 'required|numeric|min:0',
        'precioReferencia2' => 'nullable|numeric|min:0',
        'precioReferencia3' => 'nullable|numeric|min:0',
        'observaciones' => 'nullable|string',
        'estado' => 'required|boolean',
        'base_id' => 'required|integer', // Validación para base_id
    ];

    public function render()
    {
        $productos = Producto::with('existencias')
            ->when($this->search, function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('tipoContenido', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('id')
            ->paginate(4);

        return view('livewire.productos', compact('productos'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        $this->reset([
            'producto_id',
            'nombre',
            'imagen',
            'tipoContenido',
            'tipoProducto',
            'capacidad',
            'unidad',
            'precioReferencia',
            'precioReferencia2',
            'precioReferencia3',
            'observaciones',
            'estado',
            'base_id', // Asegúrate de resetear base_id aquí también
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
        $this->base_id = $producto->base_id; // Asegúrate de cargar base_id también
        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate();

        try {
            $imagenPath = null;
            if ($this->imagen) {
                $imagenPath = $this->imagen->store('productos', 'public');
            }

            Producto::updateOrCreate(['id' => $this->producto_id], [
                'nombre' => $this->nombre,
                'tipoContenido' => $this->tipoContenido,
                'tipoProducto' => $this->tipoProducto,
                'capacidad' => $this->capacidad,
                'unidad' => $this->unidad,
                'precioReferencia' => $this->precioReferencia,
                'precioReferencia2' => $this->precioReferencia2,
                'precioReferencia3' => $this->precioReferencia3,
                'observaciones' => $this->observaciones,
                'estado' => $this->estado,
                'base_id' => $this->base_id, // Incluir base_id en el guardado
                'imagen' => $imagenPath,
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
        $this->reset([
            'producto_id',
            'nombre',
            'imagen',
            'tipoContenido',
            'tipoProducto',
            'capacidad',
            'unidad',
            'precioReferencia',
            'precioReferencia2',
            'precioReferencia3',
            'observaciones',
            'estado',
            'base_id', // Resetear base_id al cerrar el modal
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
