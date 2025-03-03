<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Race;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class APIRaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las carreras con sus relaciones
        $races = Race::all();

        // Retornar la respuesta JSON
        return response()->json([
            'status' => 'success',
            'race' => $races,
            'msg' => 'Carreras obtenidas correctamente'
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $race = Race::create($request->all());

        return response()->json([
            'status' => 'success',
            'msg' => 'Carrera creada correctamente',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar la carrera por ID
        $race = Race::find($id);

        return response()->json([
            'status' => 'success',
            'race' => $race,
            'msg' => 'Carrera obtenida correctamente'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /* // Verificar permisos de administrador
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'No tienes permisos para actualizar carreras'
            ], 403);
        } */

        // Buscar la carrera por ID
        $race = Race::find($id);
        
        $race->update($request->all());

        return response()->json([
            'status' => 'success',
            'msg' => 'Carrera actualizada correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /* // Verificar permisos de administrador
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'No tienes permisos para eliminar carreras'
            ], 403);
        } */

        // Buscar la carrera por ID
        $race = Race::find($id);
        
        // Eliminar la carrera
        $race->delete();

        // Retornar respuesta exitosa
        return response()->json([
            'status' => 'success',
            'message' => 'Carrera eliminada correctamente'
        ], 200);
    }
}
