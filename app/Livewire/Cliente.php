<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Trait para paginación
use App\Models\Cliente as ModeloCliente;

class Cliente extends Component
{
    use WithPagination;

    // Propiedad para búsqueda (opcional, pero útil con paginación)
    public $search = '', $modal = 0, $accion;

    // Propiedades para los campos del formulario
    public $nombre = '';
    public $empresa = '';
    public $nitCi = '';
    public $telefono = '';
    public $correo = '';
    public $estado = true; // Por defecto activo

    // Tema de paginación para Tailwind
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        // Obtener clientes con paginación y filtro de búsqueda
        $clientes = ModeloCliente::when($this->search, function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('empresa', 'like', '%' . $this->search . '%')
                  ->orWhere('nitCi', 'like', '%' . $this->search . '%')
                  ->orWhere('telefono', 'like', '%' . $this->search . '%')
                  ->orWhere('correo', 'like', '%' . $this->search . '%');
        })->paginate(2); // 10 registros por página

        return view('livewire.cliente', compact('clientes'));
    }

    // Método para resetear la página al actualizar la búsqueda
    public function updatingSearch()
    {
        $this->resetPage(); // Resetea a la primera página cuando se busca
    }

    // Método para abrir el modal
    public function abrirModal($accion)
    {
        $this->reset(['nombre', 'empresa', 'nitCi', 'telefono', 'correo', 'estado']);
        $this->accion = $accion;
        $this->modal = true;
    }
}