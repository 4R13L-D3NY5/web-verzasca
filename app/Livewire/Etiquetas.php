<?php

namespace App\Livewire;

use App\Models\Etiqueta;
use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Etiquetas extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $modalDetalle = false;
    public $etiqueta_id = null;
    public $imagen = '';
    public $capacidad = '';
    public $unidad = '';
    public $estado = 1;
    public $cliente_id = '';
    public $clientes;
    public $accion = 'create';
    public $etiquetaSeleccionada = [];

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'imagen' => 'required|string|max:255',
        'capacidad' => 'required|string|max:255',
        'unidad' => 'nullable|in:L,ml,g,Kg,unidad',
        'estado' => 'required|boolean',
        'cliente_id' => 'nullable|exists:clientes,id',
    ];

    public function mount()
    {
        $this->clientes = Cliente::all(); // Carga todos los clientes disponibles
    }

    public function render()
    {
        $etiquetas = Etiqueta::when($this->search, function ($query) {
            $query->where('imagen', 'like', '%' . $this->search . '%')
                  ->orWhere('capacidad', 'like', '%' . $this->search . '%');
        })->paginate(4);

        return view('livewire.etiquetas', compact('etiquetas'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        $this->reset(['imagen', 'capacidad', 'unidad', 'estado', 'cliente_id']);
        $this->accion = $accion;
        if ($accion === 'edit' && $id) {
            $this->editar($id);
        }
        $this->modal = true;
    }

    public function editar($id)
    {
        $etiqueta = Etiqueta::findOrFail($id);
        $this->etiqueta_id = $etiqueta->id;
        $this->imagen = $etiqueta->imagen;
        $this->capacidad = $etiqueta->capacidad;
        $this->unidad = $etiqueta->unidad;
        $this->estado = $etiqueta->estado;
        $this->cliente_id = $etiqueta->cliente_id;
        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate();

        try {
            Etiqueta::updateOrCreate(['id' => $this->etiqueta_id], [
                'imagen' => $this->imagen,
                'capacidad' => $this->capacidad,
                'unidad' => $this->unidad,
                'estado' => $this->estado,
                'cliente_id' => $this->cliente_id ?: null,
            ]);

            LivewireAlert::title($this->etiqueta_id ? 'Etiqueta actualizada con éxito.' : 'Etiqueta creada con éxito.')
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
        $this->reset(['imagen', 'capacidad', 'unidad', 'estado', 'cliente_id', 'etiqueta_id']);
        $this->resetErrorBag();
    }

    public function modaldetalle($id)
    {
        $this->etiquetaSeleccionada = Etiqueta::findOrFail($id);
        $this->modalDetalle = true;
    }

    public function cerrarModalDetalle()
    {
        $this->modalDetalle = false;
        $this->etiquetaSeleccionada = null;
    }
}