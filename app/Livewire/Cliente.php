<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use App\Models\Cliente as ModeloCliente;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Cliente extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $detalleModal = false;
    public $accion = 'create';
    public $clienteId = null;
    public $nombre = '';
    public $empresa = '';
    public $razonSocial = '';
    public $nitCi = '';
    public $telefono = '';
    public $correo = '';
    public $latitud = '';
    public $longitud = '';
    public $foto = null;
    public $estado = 1;
    public $clienteSeleccionado = null;
    public $coordenadas;
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $clientes = ModeloCliente::when($this->search, function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('empresa', 'like', '%' . $this->search . '%')
                ->orWhere('nitCi', 'like', '%' . $this->search . '%')
                ->orWhere('telefono', 'like', '%' . $this->search . '%')
                ->orWhere('correo', 'like', '%' . $this->search . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.cliente', compact('clientes'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion)
    {
        $this->reset([
            'nombre',
            'empresa',
            'razonSocial',
            'nitCi',
            'telefono',
            'correo',
            'latitud',
            'longitud',
            'foto',
            'estado',
            'clienteId'
        ]);
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
        $this->razonSocial = $cliente->razonSocial;
        $this->nitCi = $cliente->nitCi;
        $this->telefono = $cliente->telefono;
        $this->correo = $cliente->correo;
        $this->latitud = $cliente->latitud;
        $this->longitud = $cliente->longitud;
        $this->foto = $cliente->foto;
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
            'razonSocial' => 'nullable|string|max:255',
            'nitCi' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'foto' => $this->accion === 'edit' && !is_object($this->foto)
                ? 'nullable|string|max:255'
                : 'nullable|image|max:2048', // Acepta imagen de hasta 2MB
            'estado' => 'required|boolean',
        ];

        $this->validate($rules);

        try {
            // 📌 EDITAR CLIENTE
            if ($this->accion === 'edit' && $this->clienteId) {
                $cliente = ModeloCliente::findOrFail($this->clienteId);

                // Si subieron nueva foto
                if (is_object($this->foto)) {
                    $rutaFoto = $this->foto->store('clientes', 'public');

                    // Opcional: borrar foto anterior si existía
                    if ($cliente->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($cliente->foto)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($cliente->foto);
                    }
                } else {
                    $rutaFoto = $this->foto; // Mantener la misma foto
                }

                $cliente->update([
                    'nombre' => $this->nombre,
                    'empresa' => $this->empresa,
                    'razonSocial' => $this->razonSocial,
                    'nitCi' => $this->nitCi,
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'latitud' => $this->latitud,
                    'longitud' => $this->longitud,
                    'foto' => $rutaFoto,
                    'estado' => $this->estado,
                ]);

                LivewireAlert::title('Cliente actualizado con éxito.')
                    ->success()
                    ->show();
            } else {
                // 📌 CREAR CLIENTE NUEVO
                $rutaFoto = null;
                if ($this->foto) {
                    $rutaFoto = $this->foto->store('clientes', 'public');
                }

                ModeloCliente::create([
                    'nombre' => $this->nombre,
                    'empresa' => $this->empresa,
                    'razonSocial' => $this->razonSocial,
                    'nitCi' => $this->nitCi,
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'latitud' => $this->latitud,
                    'longitud' => $this->longitud,
                    'foto' => $rutaFoto,
                    'estado' => $this->estado,
                ]);

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

    public function toggleVerificado($clienteId)
    {
        try {
            $cliente = ModeloCliente::findOrFail($clienteId);
            $nuevoEstado = !$cliente->verificado; // Toggle: 0 -> 1 or 1 -> 0
            $cliente->update(['verificado' => $nuevoEstado]);

            if ($nuevoEstado) {
                LivewireAlert::title('Cliente verificado con éxito.')
                    ->success()
                    ->show();
            } else {
                LivewireAlert::title('Verificación cancelada.')
                    ->warning()
                    ->show();
            }
        } catch (\Exception $e) {
            LivewireAlert::title('Error al actualizar la verificación: ' . $e->getMessage())
                ->error()
                ->show();
        }
    }
    public function separarCoordenadas()
    {
        if ($this->coordenadas) {
            $coords = explode(',', $this->coordenadas);
            if (count($coords) === 2) {
                $this->latitud = trim($coords[0]);
                $this->longitud = trim($coords[1]);
            }
        }
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->detalleModal = false;
        $this->reset([
            'nombre',
            'empresa',
            'razonSocial',
            'nitCi',
            'telefono',
            'correo',
            'latitud',
            'longitud',
            'foto',
            'estado',
            'clienteId',
            'clienteSeleccionado'
        ]);
        $this->resetErrorBag();
    }
}
