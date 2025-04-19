<?php

namespace App\Http\Controllers;

use App\Models\Cliente; // Asegúrate de que el modelo sea correcto
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect; //

class MapaClienteController extends Controller
{
    public function mostrar()
    {
        // Utilizamos paginate para paginar los resultados
        $clientes = Cliente::whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->paginate(5); // Cambié get() por paginate(5)

        return view('clientes.mapa', compact('clientes'));
    }
    public function mostrarFormularioMapa()
    {
        return view('clientes.registrar');
    }

    public function index()
    {
        // Si tenés una vista para listar clientes
        $clientes = Cliente::paginate(5);
        return view('clientes.index', compact('clientes'));
    }
    public function store(Request $request)
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
            'foto' => 'nullable|image|max:4096',
            'estado' => 'required|boolean',
        ];

        $validated = $request->validate($rules);

        try {
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('fotos', 'public');
            }

            Cliente::create([
                'nombre' => $validated['nombre'],
                'empresa' => $validated['empresa'],
                'razonSocial' => $validated['razonSocial'],
                'nitCi' => $validated['nitCi'],
                'telefono' => $validated['telefono'],
                'correo' => $validated['correo'],
                'latitud' => $validated['latitud'],
                'longitud' => $validated['longitud'],
                'foto' => $fotoPath,
                'estado' => $validated['estado'],
            ]);

            return Redirect::route('home')->with('success', 'Cliente registrado con éxito.');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function showMapClient(Request $request)
    {        
        $cliente = Cliente::findOrFail($request->id);
        return view('clientes.mapaCliente', compact( 'cliente'));
    }
}
