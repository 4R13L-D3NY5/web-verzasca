<?php

namespace App\Livewire;

use App\Models\Elaboracion as ModelElaboracion;
use App\Models\Personal;
use App\Models\Existencia;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Elaboracion extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $accion = 'create';

    public $elaboracionId = null;
    public $fecha_elaboracion;
    public $personal_id;
    public $existencia_entrada_id;
    public $cantidad_entrada;
    public $cantidad_salida;
    public $observaciones;
    public $modalDetalle = false;
    public $elaboracionSeleccionada= [];
    public $personales = [];
    public $existencias_preforma = [];

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'fecha_elaboracion' => 'required|date',
        'personal_id' => 'required|exists:personals,id',
        'existencia_entrada_id' => 'required|exists:existencias,id',
        'cantidad_entrada' => 'required|integer|min:1',
        'cantidad_salida' => 'nullable|integer|min:0',
        'observaciones' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        $this->personales = Personal::all();
        $this->existencias_preforma = Existencia::where('existenciable_type', 'App\\Models\\Preforma')->get();
    }

    public function render()
    {
        $elaboraciones = ModelElaboracion::with(['personal'])
            ->when($this->search, function ($query) {
                $query->whereDate('fecha_elaboracion', $this->search)
                    ->orWhereHas('personal', function ($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest()
            ->paginate(5);

        return view('livewire.elaboracion', compact('elaboraciones'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->resetForm();
        $this->accion = 'create';
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->resetForm();
        $this->resetErrorBag();
    }

    public function editar($id)
    {
        $elaboracion = ModelElaboracion::findOrFail($id);
        $this->elaboracionId = $elaboracion->id;
        $this->fecha_elaboracion = $elaboracion->fecha_elaboracion;
        $this->personal_id = $elaboracion->personal_id;
        $this->existencia_entrada_id = $elaboracion->existencia_entrada_id;
        $this->cantidad_entrada = $elaboracion->cantidad_entrada;
        $this->cantidad_salida = $elaboracion->cantidad_salida;
        $this->observaciones = $elaboracion->observaciones;

        $this->accion = 'edit';
        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate();

        try {
            if ($this->accion === 'edit' && $this->elaboracionId) {
                ModelElaboracion::findOrFail($this->elaboracionId)->update([
                    'fecha_elaboracion' => $this->fecha_elaboracion,
                    'personal_id' => $this->personal_id,
                    'existencia_entrada_id' => $this->existencia_entrada_id,
                    'cantidad_entrada' => $this->cantidad_entrada,
                    'cantidad_salida' => $this->cantidad_salida,
                    'observaciones' => $this->observaciones,
                ]);
                LivewireAlert::title('Elaboración actualizada con éxito.')->success()->show();
            } else {
                ModelElaboracion::create([
                    'fecha_elaboracion' => $this->fecha_elaboracion,
                    'personal_id' => $this->personal_id,
                    'existencia_entrada_id' => $this->existencia_entrada_id,
                    'cantidad_entrada' => $this->cantidad_entrada,
                    'cantidad_salida' => $this->cantidad_salida,
                    'observaciones' => $this->observaciones,
                ]);
                LivewireAlert::title('Elaboración registrada con éxito.')->success()->show();
            }

            $this->cerrarModal();
        } catch (\Exception $e) {
            LivewireAlert::title('Error: ' . $e->getMessage())->error()->show();
        }
    }

    private function resetForm()
    {
        $this->reset([
            'elaboracionId',
            'fecha_elaboracion',
            'personal_id',
            'existencia_entrada_id',
            'cantidad_entrada',
            'cantidad_salida',
            'observaciones',
        ]);
    }
    public function modaldetalle($id)
    {
        $this->elaboracionSeleccionada = ModelElaboracion::findOrFail($id);
        $this->modalDetalle = true;
    }

    public function cerrarModalDetalle()
    {
        $this->modalDetalle = false;
        $this->elaboracionSeleccionada = null;
    }
}
