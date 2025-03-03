<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Driver;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('teams.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'country' => 'required|string|max:255',
            'year_founded' => 'required|integer|min:1900|max:' . date('Y'),
            'championships' => 'required|integer|min:0',
        ]);

        // Manejar el logo si se ha subido
        if ($request->hasFile('logo')) {
            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('images/teams'), $fileName);
            $validated['logo'] = $fileName; // Almacena solo el nombre del archivo
        }

        // Crear el equipo
        $team = Team::create($validated);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Equipo creado correctamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $team->load('drivers');

        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        // Cargar los pilotos asociados
        $team->load('drivers');

        // Obtener los pilotos disponibles (sin equipo o con team_id nulo)
        $availableDrivers = Driver::whereNull('team_id')->orderBy('number')->get();

        return view('teams.edit', compact('team', 'availableDrivers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'country' => 'required|string|max:255',
            'year_founded' => 'required|integer|min:1900|max:' . date('Y'),
            'championships' => 'required|integer|min:0',
            'delete_logo' => 'nullable|boolean',
        ]);

        // Procesar la imagen
        if ($request->hasFile('logo')) {
            // Si hay una nueva imagen, eliminar la anterior
            if ($team->logo && file_exists(public_path('images/teams/' . $team->logo))) {
                unlink(public_path('images/teams/' . $team->logo));
            }
            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('images/teams'), $fileName);
            $validated['logo'] = $fileName;
        }
        // Si se marcó para eliminar la imagen
        elseif ($request->has('delete_logo') && $request->delete_logo) {
            if ($team->logo && file_exists(public_path('images/teams/' . $team->logo))) {
                unlink(public_path('images/teams/' . $team->logo));
            }
            $validated['logo'] = null;
        }

        // Quitar campo delete_logo para no guardarlo en la BD
        if (isset($validated['delete_logo'])) {
            unset($validated['delete_logo']);
        }


        $team->update($validated);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Equipo actualizado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        // Eliminar el logo si existe
        if ($team->logo && Storage::disk('public')->exists($team->logo)) {
            Storage::disk('public')->delete($team->logo);
        }

        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}
