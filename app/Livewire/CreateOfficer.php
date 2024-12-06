<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Officer;
use App\Models\LType;

class CreateOfficer extends Component
{
    use WithPagination;

    public $name;
    public $license_ids = []; // Array para múltiples licencias
    public $modalC = false;
    public $modalE = false;
    public $idEditable;
    public $Edit = [
        'id' => '',
        'name' => '',
        'license_ids' => [], // Array para múltiples licencias en la edición
    ];

    protected $rules = [
        'name' => 'required',
        'license_ids' => 'required',
    ];
    public $search = '';

    public function render()
    {
        $officers = Officer::where('name', 'like', '%' . $this->search . '%')
                           ->orWhereHas('licenses', function ($query) { // Cambiado a "licenses"
                               $query->where('name', 'like', '%' . $this->search . '%');
                           })
                           ->paginate(5);

        $licenses = LType::all();

        return view('livewire.create-officer', [
            'officers' => $officers,
            'licenses' => $licenses,
        ]);
    }

    public function save()
    {
        $this->validate();
        $officer = Officer::create([
            'name' => $this->name,
            'license_id' => $this->license_ids ? $this->license_ids[0] : 1, // Aquí 1 es un ID por defecto
        ]);

        if ($this->license_ids) {
            $officer->licenses()->sync($this->license_ids);
        }

        $this->reset(['name', 'license_ids']);
        $this->modalC = false;
    }


    public function updated($propertyName)
    {
        if ($propertyName === 'search') {
            $this->resetPage();
        }
    }

    public function delete($id)
    {
        $officer = Officer::find($id);
        if ($officer) {
            $officer->licenses()->detach(); // Eliminar relaciones antes de borrar
            $officer->delete();
        }
    }

    public function edit($id)
    {
        $this->modalE = true;
        $officer = Officer::find($id);

        if ($officer) {
            $this->idEditable = $officer->id;
            $this->Edit['id'] = $officer->id;
            $this->Edit['name'] = $officer->name;
            $this->Edit['license_ids'] = $officer->licenses->pluck('id')->toArray(); // Obtener IDs de licencias relacionadas
        }
    }

    public function update()
{
    $officer = Officer::find($this->idEditable);

    if ($officer) {
        $officer->update(['name' => $this->Edit['name']]);
        $officer->licenses()->sync($this->Edit['license_ids']);
        $this->reset(['Edit', 'idEditable', 'modalE']);
    }
}

}
