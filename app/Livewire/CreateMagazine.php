<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Magazine;

class CreateMagazine extends Component
{
    use WithPagination;

    public $code, $weapon_id, $in_stock;
    public $modalC = false;
    public $modalE = false;
    public $idEditable;
    public $Edit = [
        'id' => '',
        'code' => '',
        'weapon_id' => '',
        'in_stock' => '',
    ];

    public $search = '';

    public function render()
    {
        $magazines = Magazine::where('code', 'like', '%' . $this->search . '%')
                             ->orWhere('weapon_id', 'like', '%' . $this->search . '%')
                             ->paginate(5);

        return view('livewire.create-magazine', [
            'magazines' => $magazines
        ]);
    }

    public function save()
{
    $magazine = new Magazine();
    $magazine->code = $this->code;
    $magazine->weapon_id = $this->weapon_id;
    $magazine->in_stock = 'disponible'; // Valor predeterminado

    $magazine->save();

    $this->reset(['code', 'weapon_id']);
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
        $magazine = Magazine::find($id);
        if ($magazine) {
            $magazine->delete();
        }
    }

    public function edit($id)
    {
        $this->modalE = true;
        $magazine = Magazine::find($id);

        if ($magazine) {
            $this->idEditable = $magazine->id;
            $this->Edit['id'] = $magazine->id;
            $this->Edit['code'] = $magazine->code;
            $this->Edit['weapon_id'] = $magazine->weapon_id;
            $this->Edit['in_stock'] = $magazine->in_stock;
        }
    }

    public function update()
    {
        $magazine = Magazine::find($this->idEditable);

        if ($magazine) {
            $magazine->update([
                'code' => $this->Edit['code'],
                'weapon_id' => $this->Edit['weapon_id'],
                'in_stock' => $this->Edit['in_stock'],
            ]);

            $this->reset(['Edit', 'idEditable', 'modalE']);
        }
    }
}
