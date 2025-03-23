<?php

namespace App\Livewire;

use App\Models\Tapa;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Tapas extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $tapa_id = null;
    public $color = '';
    public $tipo = '';
    public $estado = 1;
    public $accion = 'create';

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'color' => 'required|string',
        'tipo' => 'required|string',

    ];

    public function render()
    {
        $tapas = Tapa::when($this->search, function ($query) {
            $query->where('color', 'like', '%' . $this->search . '%')
                  ->orWhere('tipo', 'like', '%' . $this->search . '%');
        })->paginate(4);

        return view('livewire.tapas', compact('tapas'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        $this->reset(['color', 'tipo', 'estado']);
        $this->accion = $accion;
        if ($accion === 'edit' && $id) {
            $this->editar($id);
        }
        $this->modal = true;
    }

    public function editar($id)
    {
        $tapa = Tapa::findOrFail($id);
        $this->tapa_id = $tapa->id;
        $this->color = $tapa->color;
        $this->tipo = $tapa->tipo;
        $this->estado = $tapa->estado;
        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate();

        try {
            Tapa::updateOrCreate(['id' => $this->tapa_id], [
                'color' => $this->color,
                'tipo' => $this->tipo,
                'estado' => $this->estado,
            ]);

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
        $this->reset(['color', 'tipo', 'estado', 'tapa_id']);
        $this->resetErrorBag();
    }
}
