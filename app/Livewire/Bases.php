<?php

namespace App\Livewire;

use App\Models\Base;
use App\Models\Preforma; // Necesario para el dropdown
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Bases extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $modalDetalle = false;
    public $base_id = null; // Cambiado de preforma_id
    public $capacidad = ''; // Campo de la tabla bases
    public $estado = 1; // Campo de la tabla bases
    public $observaciones = ''; // Campo de la tabla bases
    public $preforma_id = null; // Clave foránea
    public $accion = 'create';
    public $baseSeleccionada = null; // Cambiado de preformaSeleccionada
    public $todasLasPreformas = []; // Para el dropdown del modal

    protected $paginationTheme = 'tailwind';

    // Reglas de validación adaptadas para Bases
    protected $rules = [
        'capacidad' => 'required|integer|min:0',
        'estado' => 'required|boolean',
        'observaciones' => 'nullable|string',
        'preforma_id' => 'nullable|exists:preformas,id', // Validar que la preforma exista si se selecciona
    ];

    // Mensajes de error personalizados (opcional)
    protected $messages = [
        'capacidad.required' => 'La capacidad es obligatoria.',
        'capacidad.integer' => 'La capacidad debe ser un número entero.',
        'capacidad.min' => 'La capacidad no puede ser negativa.',
        'estado.required' => 'El estado es obligatorio.',
        'preforma_id.exists' => 'La preforma seleccionada no es válida.',
    ];

    // Cargar preformas activas cuando el componente se inicializa
    public function mount()
    {
        $this->todasLasPreformas = Preforma::where('estado', 1)->orderBy('insumo')->get();
    }

    public function render()
    {
        $bases = Base::with(['existencias', 'preforma']) // Cargar relaciones para mostrar info
            ->when($this->search, function ($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where('capacidad', 'like', $searchTerm) // Buscar por capacidad
                    ->orWhereHas('preforma', function ($subQuery) use ($searchTerm) { // Buscar por insumo de preforma relacionada
                        $subQuery->where('insumo', 'like', $searchTerm);
                    });
                    //->orWhere('observaciones', 'like', $searchTerm); // Opcional: buscar en observaciones
            })
            ->paginate(4); // Ajusta la paginación si es necesario

        return view('livewire.bases', compact('bases'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        // Resetear propiedades del formulario para Bases
        $this->reset(['capacidad', 'estado', 'observaciones', 'preforma_id', 'base_id']);
        $this->accion = $accion;
        if ($accion === 'edit' && $id) {
            $this->editar($id);
        }
        $this->modal = true;
    }

    public function editar($id)
    {
        $base = Base::findOrFail($id);
        $this->base_id = $base->id;
        $this->capacidad = $base->capacidad;
        $this->estado = $base->estado;
        $this->observaciones = $base->observaciones;
        $this->preforma_id = $base->preforma_id; // Cargar ID de preforma asociada
        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate(); // Validar con las reglas definidas

        try {
            Base::updateOrCreate(['id' => $this->base_id], [
                'capacidad' => $this->capacidad,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
                'preforma_id' => $this->preforma_id ?: null, // Guardar null si no se selecciona preforma
                // Falta manejar 'imagen' si se implementa subida de archivos
            ]);

            LivewireAlert::title($this->base_id ? 'Base actualizada con éxito.' : 'Base creada con éxito.')
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
        // Resetear propiedades del formulario para Bases
        $this->reset(['capacidad', 'estado', 'observaciones', 'preforma_id', 'base_id']);
        $this->resetErrorBag(); // Limpiar errores de validación
    }

    // FUNCIONALIDAD PARA MODAL DE DETALLES
    public function modaldetalle($id)
    {
        // Cargar Base con su Preforma asociada para mostrar detalles
        $this->baseSeleccionada = Base::with('preforma')->findOrFail($id);
        $this->modalDetalle = true;
    }

    public function cerrarModalDetalle()
    {
        $this->modalDetalle = false;
        $this->baseSeleccionada = null; // Limpiar la base seleccionada
    }
}