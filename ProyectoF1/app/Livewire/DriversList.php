<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Driver;
use Illuminate\Support\Facades\Storage;

class DriversList extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDriverDeletion = false;
    public $driverIdToDelete = null;

    protected $queryString = ['search' => ['except' => '']];

    // Este método se activa cuando cambia el valor de search
    public function updatingSearch()
    {
        // Resetear la página de paginación al buscar
        $this->resetPage();
    }

    public function render()
    {
        $query = Driver::with('team');

        // Búsqueda
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('number', 'like', "%{$search}%")
                    ->orWhereHas('team', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Ordenación
        $query->orderBy('name', 'asc');

        // Paginación
        $drivers = $query->paginate(9);

        return view('livewire.drivers-list', [
            'drivers' => $drivers
        ]);
    }

    public function confirmDriverDeletion($driverId)
    {
        $this->driverIdToDelete = $driverId;
        $this->confirmingDriverDeletion = true;
    }

    // Método para cancelar la eliminación
    public function cancelDriverDeletion()
    {
        $this->confirmingDriverDeletion = false;
        $this->driverIdToDelete = null;
    }

    // Método que elimina el piloto después de confirmar
    public function deleteDriver()
    {
        $driver = Driver::find($this->driverIdToDelete);

        if ($driver) {
            // Eliminar la imagen si existe
            if ($driver->photo && Storage::disk('public')->exists($driver->photo)) {
                Storage::disk('public')->delete($driver->photo);
            }

            $driver->delete();

            session()->flash('message', 'Piloto eliminado correctamente.');
        }
        
        $this->confirmingDriverDeletion = false;
        $this->driverIdToDelete = null;
    }
}