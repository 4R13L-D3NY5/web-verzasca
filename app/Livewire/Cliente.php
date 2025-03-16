<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use App\Models\Cliente as ModeloCliente;

class Cliente extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $detalleModal = false;
    public $accion = 'create';
    public $clienteId = null;
    public $nombre = '';
    public $empresa = '';
    public $nitCi = '';
    public $telefono = '';
    public $correo = '';
    public $estado = 1;
    public $clienteSeleccionado = null;

    protected $paginationTheme = 'tailwind';



    public function render()
    {
        $clientes = ModeloCliente::when($this->search, function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('empresa', 'like', '%' . $this->search . '%')
                ->orWhere('nitCi', 'like', '%' . $this->search . '%')
                ->orWhere('telefono', 'like', '%' . $this->search . '%')
                ->orWhere('correo', 'like', '%' . $this->search . '%');
        })->paginate(5);

        return view('livewire.cliente', compact('clientes'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion)
    {
        $this->reset(['nombre', 'empresa', 'nitCi', 'telefono', 'correo', 'estado', 'clienteId']);
        $this->accion = $accion;
        $this->estado = 1;
        $this->modal = true;
        $this->detalleModal = false;
    }

    public function editarCliente($id)
    {
        $cliente = ModeloCliente::findOrFail($id);
        $this->clienteId = $cliente->id;
        $this->nombre = $cliente->nombre;
        $this->empresa = $cliente->empresa;
        $this->nitCi = $cliente->nitCi;
        $this->telefono = $cliente->telefono;
        $this->correo = $cliente->correo;
        $this->estado = $cliente->estado;
        $this->accion = 'edit';
        $this->modal = true;
        $this->detalleModal = false;
    }

    public function verDetalle($id)
    {
        $this->clienteSeleccionado = ModeloCliente::findOrFail($id);
        $this->modal = false;
        $this->detalleModal = true;
    }

    public function guardarCliente()
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'nitCi' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'estado' => 'required|boolean',
        ];
        $this->validate($rules);
        try {

            if ($this->accion === 'edit' && $this->clienteId) {
                $cliente = ModeloCliente::findOrFail($this->clienteId);
                $cliente->update([
                    'nombre' => $this->nombre,
                    'empresa' => $this->empresa,
                    'nitCi' => $this->nitCi,
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'estado' => $this->estado,
                ]);
                // $this->alert('success', 'Cliente actualizado con éxito.');
                LivewireAlert::title('Cliente actualizado con éxito.')
                    ->success()
                    ->show();
            } else {
                ModeloCliente::create([
                    'nombre' => $this->nombre,
                    'empresa' => $this->empresa,
                    'nitCi' => $this->nitCi,
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'estado' => $this->estado,
                ]);
                // $this->alert('success', 'Cliente registrado con éxito.');
                LivewireAlert::title('Cliente registrado con éxito.')
                    ->success()
                    ->show();
            }

            $this->cerrarModal();
        } catch (\Exception $e) {
            LivewireAlert::title($e->getMessage())
                ->error()
                ->show();
        }
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->detalleModal = false;
        $this->reset(['nombre', 'empresa', 'nitCi', 'telefono', 'correo', 'estado', 'clienteId', 'clienteSeleccionado']);
        $this->resetErrorBag();
    }
}
