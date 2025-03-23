<?php

namespace App\Livewire;

use App\Models\Base;
use App\Models\Preforma;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Bases extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $base_id = null;
    public $capacidad = '';
    public $estado = 1;
    public $observaciones = '';
    public $preforma_id = '';
    public $accion = 'create';

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'capacidad' => 'required|integer|min:1',
        'estado' => 'required|boolean',
        'observaciones' => 'nullable|string',
        'preforma_id' => 'nullable|exists:preformas,id',
    ];

    public function render()
    {
        $bases = Base::with('preforma')
            ->when($this->search, function ($query) {
                $query->where('capacidad', 'like', '%' . $this->search . '%');
            })
            ->paginate(4);

        $preformas = Preforma::all();

        return view('livewire.bases', compact('bases', 'preformas'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        $this->reset(['capacidad', 'estado', 'observaciones', 'preforma_id']);
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
        $this->preforma_id = $base->preforma_id;
        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate();

        try {
            Base::updateOrCreate(['id' => $this->base_id], [
                'capacidad' => $this->capacidad,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
                'preforma_id' => $this->preforma_id,
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
        $this->reset(['capacidad', 'estado', 'observaciones', 'preforma_id', 'base_id']);
        $this->resetErrorBag();
    }
}
