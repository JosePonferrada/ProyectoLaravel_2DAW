<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Circuit;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $races = Race::with('circuit')
            ->orderByDesc('date')
            ->paginate(4);

        return view('races.index', compact('races'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar permisos
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('races.index')->with('error', 'No tienes permisos para crear carreras.');
        }

        // Obtener todos los circuitos para el selector
        $circuits = Circuit::orderBy('name')->get();

        // Año actual para la temporada por defecto
        $currentYear = date('Y');

        return view('races.create', compact('circuits', 'currentYear'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar permisos
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('races.index')->with('error', 'No tienes permisos para crear carreras.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'circuit_id' => 'required|exists:circuits,id',
            'laps' => 'required|integer|min:1',
            'weather' => 'nullable|string|max:255',
        ]);

        Race::create($validated);

        return redirect()->route('races.index')
            ->with('success', 'Carrera creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Race $race)
    {
        $race->load(['circuit', 'drivers.team']);

        // Ordenar los pilotos por posición
        $race->drivers = $race->drivers->sortBy('pivot.position');

        return view('races.show', compact('race'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Race $race)
    {
        // Verificar permisos
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('races.index')->with('error', 'No tienes permisos para editar carreras.');
        }

        $circuits = Circuit::orderBy('name')->get();

        return view('races.edit', compact('race', 'circuits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Race $race)
    {
        // Verificar permisos
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('races.index')->with('error', 'No tienes permisos para actualizar carreras.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'circuit_id' => 'required|exists:circuits,id',
            'laps' => 'required|integer|min:1',
            'weather' => 'nullable|string|max:255',
        ]);

        $race->update($validated);

        return redirect()->route('races.index')
            ->with('success', 'Carrera actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Race $race)
    {
        // Verificar permisos
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('races.index')->with('error', 'No tienes permisos para eliminar carreras.');
        }

        // Verificar si hay pilotos asociados (resultados)
        if ($race->drivers()->count() > 0) {
            return redirect()->route('races.index')
                ->with('error', 'No se puede eliminar la carrera porque tiene resultados asociados.');
        }

        try {
            $race->delete();
            return redirect()->route('races.index')
                ->with('success', 'Carrera eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('races.index')
                ->with('error', 'Error al eliminar la carrera: ' . $e->getMessage());
        }
    }
}