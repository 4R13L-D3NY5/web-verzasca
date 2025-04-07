<?php

namespace App\Livewire;

use App\Models\Tapa; // Cambiado a modelo Tapa
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Tapas extends Component // Cambiado nombre de clase
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $modalDetalle = false;
    public $tapa_id = null; // Cambiado de base_id
    public $color = ''; // Campo de la tabla tapas
    public $tipo = ''; // Campo de la tabla tapas
    public $estado = 1; // Campo de la tabla tapas (asumiendo 1=activo, 0=inactivo)
    public $accion = 'create';
    public $tapaSeleccionada = null; // Cambiado de baseSeleccionada

    protected $paginationTheme = 'tailwind';

    // Reglas de validación adaptadas para Tapas
    protected $rules = [
        'color' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'estado' => 'required|boolean', // Livewire suele manejar bien tinyint(1) como boolean
    ];

    // Mensajes de error personalizados (opcional)
    protected $messages = [
        'color.required' => 'El color es obligatorio.',
        'tipo.required' => 'El tipo es obligatorio.',
        'estado.required' => 'El estado es obligatorio.',
    ];

    // No necesitamos mount() aquí ya que no hay datos precargados como preformas

    public function render()
    {
        // Cambiado a modelo Tapa y relaciones
        $tapas = Tapa::with(['existencias']) // Cargar relación polimórfica existencias
            ->when($this->search, function ($query) {
                $searchTerm = '%' . $this->search . '%';
                // Buscar por color o tipo
                $query->where('color', 'like', $searchTerm)
                      ->orWhere('tipo', 'like', $searchTerm);
            })
            ->paginate(4); // Ajusta la paginación si es necesario

        // Cambiado a vista livewire.tapas
        return view('livewire.tapas', compact('tapas'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        // Resetear propiedades del formulario para Tapas
        $this->reset(['color', 'tipo', 'estado', 'tapa_id']);
        $this->accion = $accion;
        if ($accion === 'edit' && $id) {
            $this->editar($id);
        }
        $this->modal = true;
    }

    public function editar($id)
    {
        // Cambiado a modelo Tapa
        $tapa = Tapa::findOrFail($id);
        $this->tapa_id = $tapa->id;
        $this->color = $tapa->color;
        $this->tipo = $tapa->tipo;
        $this->estado = $tapa->estado;
        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate(); // Validar con las reglas definidas

        try {
            // Cambiado a modelo Tapa y sus campos
            Tapa::updateOrCreate(['id' => $this->tapa_id], [
                'color' => $this->color,
                'tipo' => $this->tipo,
                'estado' => $this->estado,
                // Falta manejar 'imagen' si se implementa subida de archivos
            ]);

            // Mensajes adaptados para Tapa
            LivewireAlert::title($this->tapa_id ? 'Tapa actualizada con éxito.' : 'Tapa creada con éxito.')
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
        // Resetear propiedades del formulario para Tapas
        $this->reset(['color', 'tipo', 'estado', 'tapa_id']);
        $this->resetErrorBag(); // Limpiar errores de validación
    }

    // FUNCIONALIDAD PARA MODAL DE DETALLES
    public function modaldetalle($id)
    {
        // Cargar Tapa (sin relaciones extra necesarias según schema)
        $this->tapaSeleccionada = Tapa::findOrFail($id);
        $this->modalDetalle = true;
    }

    public function cerrarModalDetalle()
    {
        $this->modalDetalle = false;
        $this->tapaSeleccionada = null; // Limpiar la tapa seleccionada
    }
}