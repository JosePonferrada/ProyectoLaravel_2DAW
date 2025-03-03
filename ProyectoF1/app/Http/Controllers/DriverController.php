<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('drivers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cargar todos los equipos para el select
        $teams = Team::orderBy('name')->get();

        return view('drivers.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer|min:0|max:99|unique:drivers,number',
            'nationality' => 'required|string|max:255',
            'team_id' => 'nullable|exists:teams,id',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Manejar la imagen si se ha subido
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('drivers', 'public');
        }
    
        // Crear el piloto
        $driver = Driver::create($validated);
    
        return redirect()->route('drivers.show', $driver)
                         ->with('success', 'Piloto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        // Cargar relaciones necesarias para la vista de detalle
        $driver->load('team', 'races');

        return view('drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        // Verificar si el usuario es administrador
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permiso para editar pilotos.');
        }

        // Cargar todos los equipos para el select
        $teams = Team::orderBy('name')->get();

        return view('drivers.edit', compact('driver', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        // Verificar si el usuario es administrador
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permiso para actualizar pilotos.');
        }

        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer|min:0|max:99|unique:drivers,number,' . $driver->id,
            'nationality' => 'required|string|max:255',
            'team_id' => 'nullable|exists:teams,id',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_image' => 'nullable|boolean',
        ]);

        // Procesar la imagen
        if ($request->hasFile('photo')) {
            // Si hay una nueva imagen, eliminar la anterior si existe
            if ($driver->photo && Storage::disk('public')->exists($driver->photo)) {
                Storage::disk('public')->delete($driver->photo);
            }
            $validated['photo'] = $request->file('photo')->store('drivers', 'public');
        }
        // Si se marcó el checkbox para eliminar la imagen
        elseif ($request->has('delete_image')) {
            // Eliminar la imagen existente
            if ($driver->photo && Storage::disk('public')->exists($driver->photo)) {
                Storage::disk('public')->delete($driver->photo);
            }
            $validated['photo'] = null; // Establecer el campo de foto a null
        }

        // Eliminar el campo delete_image para no guardarlo en la BD
        if (isset($validated['delete_image'])) {
            unset($validated['delete_image']);
        }

        // Actualizar el piloto
        $driver->update($validated);

        return redirect()->route('drivers.show', $driver)
            ->with('success', 'Piloto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        // Verificar si el usuario es administrador
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permiso para eliminar pilotos.');
        }

        // Eliminar la imagen asociada si existe
        if ($driver->image && Storage::disk('public')->exists($driver->image)) {
            Storage::disk('public')->delete($driver->image);
        }

        // Eliminar el piloto
        $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', 'Piloto eliminado correctamente.');
    }
}
