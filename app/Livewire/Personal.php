<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Personal as ModelPersonal;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Personal extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $detalleModal = false;
    public $accion = 'create';
    public $personalId = null;

    public $nombres = '';
    public $apellidos = '';
    public $direccion = '';
    public $celular = '';
    public $estado = true;

    public $personalSeleccionado = null;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'direccion' => 'nullable|string|max:255',
        'celular' => 'required|string|max:15',
        'estado' => 'required|boolean',
    ];

    public function render()
    {
        $personales = ModelPersonal::query()
            ->when($this->search, function ($query) {
                $query->where('nombres', 'like', '%' . $this->search . '%')
                      ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                      ->orWhere('celular', 'like', '%' . $this->search . '%');
            })
            ->paginate(perPage: 4);

        return view('livewire.personal', compact('personales'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        $this->reset(['nombres', 'apellidos', 'direccion', 'celular', 'estado', 'personalId']);
        $this->accion = $accion;
        if ($accion === 'edit' && $id) {
            $this->editar($id);
        }
        $this->modal = true;
    }

    public function editar($id)
    {
        $personal = ModelPersonal::findOrFail($id);
        $this->personalId = $personal->id;
        $this->nombres = $personal->nombres;
        $this->apellidos = $personal->apellidos;
        $this->direccion = $personal->direccion;
        $this->celular = $personal->celular;
        $this->estado = $personal->estado;
        $this->accion = 'edit';
        $this->modal = true;
        $this->detalleModal = false;
    }

    public function verDetalle($id)
    {
        $this->personalSeleccionado = ModelPersonal::findOrFail($id);
        $this->modal = false;
        $this->detalleModal = true;
    }

    public function guardarPersonal()
    {
        $this->validate();

        try {
            if ($this->accion === 'edit' && $this->personalId) {
                $personal = ModelPersonal::findOrFail($this->personalId);
                $personal->update([
                    'nombres' => $this->nombres,
                    'apellidos' => $this->apellidos,
                    'direccion' => $this->direccion,
                    'celular' => $this->celular,
                    'estado' => $this->estado,
                ]);
                LivewireAlert::title('Personal actualizado con éxito.')->success()->show();
            } else {
                ModelPersonal::create([
                    'nombres' => $this->nombres,
                    'apellidos' => $this->apellidos,
                    'direccion' => $this->direccion,
                    'celular' => $this->celular,
                    'estado' => $this->estado,
                ]);
                LivewireAlert::title('Personal registrado con éxito.')->success()->show();
            }

            $this->cerrarModal();
        } catch (\Exception $e) {
            LivewireAlert::title('Ocurrió un error: ' . $e->getMessage())->error()->show();
        }
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->detalleModal = false;
        $this->reset(['nombres', 'apellidos', 'direccion', 'celular', 'estado', 'personalId', 'personalSeleccionado']);
        $this->resetErrorBag();
    }
}
