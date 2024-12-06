<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\WeaponType;

class CreateWeaponType extends Component
{
    use WithPagination;

    public $name;
    public $modalC = false;
    public $modalE = false;
    public $idEditable;
    public $Edit = [
        'id' => '',
        'name' => '',
    ];
    public $search = '';

    public function render()
    {
        $types = WeaponType::where('name', 'like', '%' . $this->search . '%')->paginate(5);

        return view('livewire.create-weapon-type', [
            'types' => $types,
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        WeaponType::create([
            'name' => $this->name,
        ]);

        $this->reset(['name']);
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
        $type = WeaponType::find($id);
        if ($type) {
            $type->delete();
        }
    }

    public function edit($id)
    {
        $this->modalE = true;
        $type = WeaponType::find($id);

        if ($type) {
            $this->idEditable = $type->id;
            $this->Edit['id'] = $type->id;
            $this->Edit['name'] = $type->name;
        }
    }

    public function update()
    {
        $this->validate([
            'Edit.name' => 'required|string|max:255',
        ]);

        $type = WeaponType::find($this->idEditable);

        if ($type) {
            $type->update([
                'name' => $this->Edit['name'],
            ]);

            $this->reset(['Edit', 'idEditable', 'modalE']);
        }
    }
}
