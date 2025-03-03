<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Team;

class TeamsList extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    // Este método se activa cuando cambia el valor de search
    public function updatingSearch()
    {
        // Resetear la página de paginación al buscar
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Team::with('drivers');
        
        // Filtrado por búsqueda
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }
        
        // Ordenar por nombre
        $query->orderBy('name');
        
        // Paginación
        $teams = $query->paginate(9);
        
        return view('livewire.teams-list', [
            'teams' => $teams
        ]);
    }
}
