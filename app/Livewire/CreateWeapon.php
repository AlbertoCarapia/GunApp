<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Weapon;
use App\Models\WeaponType;

class CreateWeapon extends Component
{
    use WithPagination;

    public $code, $type_id, $in_stock;
    public $modalC = false;
    public $modalE = false;
    public $idEditable;
    public $Edit = [
        'id' => '',
        'code' => '',
        'type_id' => '',
        'in_stock' => '',
    ];
    public $search = '';

    protected $rules = [
        'code' => 'required|string|max:255|unique:weapons,code',
        'type_id' => 'required|exists:weapon_types,id',
    ];

    public function render()
    {
        $weapons = Weapon::with('type')
                         ->where('code', 'like', '%' . $this->search . '%')
                         ->orWhereHas('type', function ($query) {
                             $query->where('name', 'like', '%' . $this->search . '%');
                         })
                         ->paginate(5);

        $types = WeaponType::all();

        return view('livewire.create-weapon', [
            'weapons' => $weapons,
            'types' => $types,
        ]);
    }

    public function save()
{

    $this->validate();

    $weapon = new Weapon();
    $weapon->code = $this->code;
    $weapon->type_id = $this->type_id;
    $weapon->in_stock = 'disponible'; // Valor predeterminado

    $weapon->save();

    $this->reset(['code', 'type_id']);
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
        $weapon = Weapon::find($id);
        if ($weapon) {
            $weapon->delete();
        }
    }

    public function edit($id)
    {
        $this->modalE = true;
        $weapon = Weapon::find($id);

        if ($weapon) {
            $this->idEditable = $weapon->id;
            $this->Edit['id'] = $weapon->id;
            $this->Edit['code'] = $weapon->code;
            $this->Edit['type_id'] = $weapon->type_id;
            $this->Edit['in_stock'] = $weapon->in_stock;
        }
    }

    public function update()
    {
        $weapon = Weapon::find($this->idEditable);

        if ($weapon) {
            $weapon->update([
                'code' => $this->Edit['code'],
                'type_id' => $this->Edit['type_id'],
                'in_stock' => $this->Edit['in_stock'],
            ]);

            $this->reset(['Edit', 'idEditable', 'modalE']);
        }
    }
}
