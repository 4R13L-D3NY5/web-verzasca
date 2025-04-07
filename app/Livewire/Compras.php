<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Personal;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Compras extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $detalleModal = false;
    public $accion = 'create';
    public $compraId = null;

    public $fecha;
    public $observaciones;
    public $proveedor_id;
    public $personal_id;

    public $compraSeleccionada = null;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'fecha' => 'required|date',
        'observaciones' => 'nullable|string',
        'proveedor_id' => 'required|exists:proveedors,id',
        'personal_id' => 'required|exists:personals,id',
    ];

    public function render()
    {
        $compras = Compra::with(['proveedor', 'personal'])
            ->when($this->search, function ($query) {
                $query->where('observaciones', 'like', '%' . $this->search . '%');
            })
            ->orderBy('fecha', 'desc')
            ->paginate(5);

        $proveedors = Proveedor::all();
        $personals = Personal::all();

        return view('livewire.compras', compact('compras', 'proveedors', 'personals'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion)
    {
        $this->reset(['fecha', 'observaciones', 'proveedor_id', 'personal_id', 'compraId']);
        $this->accion = $accion;
        $this->modal = true;
        $this->detalleModal = false;
    }

    public function editarCompra($id)
    {
        $compra = Compra::findOrFail($id);
        $this->compraId = $compra->id;
        $this->fecha = $compra->fecha;
        $this->observaciones = $compra->observaciones;
        $this->proveedor_id = $compra->proveedor_id;
        $this->personal_id = $compra->personal_id;
        $this->accion = 'edit';
        $this->modal = true;
        $this->detalleModal = false;
    }

    public function verDetalle($id)
    {
        $this->compraSeleccionada = Compra::with(['proveedor', 'personal', 'itemCompras'])->findOrFail($id);
        $this->modal = false;
        $this->detalleModal = true;
    }

    public function guardarCompra()
    {
        $this->validate();

        try {
            if ($this->accion === 'edit' && $this->compraId) {
                $compra = Compra::findOrFail($this->compraId);
                $compra->update([
                    'fecha' => $this->fecha,
                    'observaciones' => $this->observaciones,
                    'proveedor_id' => $this->proveedor_id,
                    'personal_id' => $this->personal_id,
                ]);
                LivewireAlert::title('Compra actualizada con éxito.')->success()->show();
            } else {
                Compra::create([
                    'fecha' => $this->fecha,
                    'observaciones' => $this->observaciones,
                    'proveedor_id' => $this->proveedor_id,
                    'personal_id' => $this->personal_id,
                ]);
                LivewireAlert::title('Compra registrada con éxito.')->success()->show();
            }

            $this->cerrarModal();
        } catch (\Exception $e) {
            LivewireAlert::title('Error: ' . $e->getMessage())->error()->show();
        }
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->detalleModal = false;
        $this->reset(['fecha', 'observaciones', 'proveedor_id', 'personal_id', 'compraId', 'compraSeleccionada']);
        $this->resetErrorBag();
    }
}
