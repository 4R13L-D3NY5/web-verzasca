<?php

namespace App\Livewire;

use App\Models\Etiqueta;
use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithFileUploads; // Importar para manejo de archivos

class Etiquetas extends Component
{
    use WithPagination, WithFileUploads; // Usar el trait WithFileUploads

    public $search = '';
    public $modal = false;
    public $etiqueta_id = null;
    public $imagen;
    public $capacidad = '';
    public $estado = 1;

    public $cliente_id;
    public $accion = 'create';
    public $clientes;
    public $modalDetalle = false;
    public $etiquetaSeleccionada= [];
    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'capacidad' => 'required|string',
        'estado' => 'required|boolean',
        'cliente_id' => 'nullable|exists:clientes,id',
    ];

    public function mount()
    {
        $this->clientes = Cliente::all();
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
        $this->reset(['imagen', 'capacidad', 'estado', 'cliente_id']);
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
        $this->imagen = $etiqueta->imagen;  // Aquí asignamos la imagen ya almacenada
        $this->capacidad = $etiqueta->capacidad;
        $this->estado = $etiqueta->estado;
        $this->cliente_id = $etiqueta->cliente_id;
        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate();
    
        try {
            if ($this->imagen && $this->imagen instanceof \Illuminate\Http\UploadedFile) {
                // Guardamos la nueva imagen
                $imagenPath = $this->imagen->store('etiquetas', 'public'); // Guardamos en 'storage/app/public/etiquetas'
            } elseif (is_string($this->imagen)) {
                // Si no se cargó una nueva imagen, usamos la imagen existente
                $imagenPath = $this->imagen;
            } else {
                $imagenPath = null; // Si no hay imagen, ponemos null
            }
    
            Etiqueta::updateOrCreate(['id' => $this->etiqueta_id], [
                'imagen' => $imagenPath,
                'capacidad' => $this->capacidad,
                'estado' => $this->estado,
                'cliente_id' => $this->cliente_id,
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
        $this->reset(['imagen', 'capacidad', 'estado', 'cliente_id', 'etiqueta_id']);
        $this->resetErrorBag();
    }

    // FUNCIONALIDAD PARA MODAL DE DETALLES
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
