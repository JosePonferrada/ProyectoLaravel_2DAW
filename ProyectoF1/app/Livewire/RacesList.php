<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Race;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Carbon\Carbon;

class RacesList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $sortField = 'date';
    public $sortDirection = 'desc';
    public $confirmingRaceDeletion = false;
    public $raceIdToDelete;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'date'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmRaceDeletion($raceId)
    {
        $this->raceIdToDelete = $raceId;
        $this->confirmingRaceDeletion = true;
    }

    public function deleteRace()
    {
        // Verificar permisos
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            session()->flash('error', 'No tienes permisos para eliminar carreras.');
            $this->confirmingRaceDeletion = false;
            return;
        }

        $race = Race::find($this->raceIdToDelete);

        if (!$race) {
            session()->flash('error', 'Carrera no encontrada.');
            $this->confirmingRaceDeletion = false;
            return;
        }

        // Verificar si hay pilotos asociados (resultados)
        if ($race->drivers()->count() > 0) {
            session()->flash('error', 'No se puede eliminar la carrera porque tiene resultados asociados.');
            $this->confirmingRaceDeletion = false;
            return;
        }

        try {
            $race->delete();
            session()->flash('success', 'Carrera eliminada correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la carrera: ' . $e->getMessage());
        }

        $this->confirmingRaceDeletion = false;
    }

    public function render()
    {
        $races = Race::with('circuit')
            ->when($this->search, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('circuit', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('location', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.races-list', [
            'races' => $races,
        ]);
    }
}