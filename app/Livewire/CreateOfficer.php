<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Officer;
use App\Models\LType;

class CreateOfficer extends Component
{
    use WithPagination;

    public $name, $license_id;
    public $modalC = false;
    public $modalE = false;
    public $idEditable;
    public $Edit = [
        'id' => '',
        'name' => '',
        'license_id' => '',
    ];
    public $search = '';

    public function render()
    {
        $officers = Officer::where('name', 'like', '%' . $this->search . '%')
                           ->orWhereHas('license', function ($query) {
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
        $officer = new Officer();
        $officer->name = $this->name;
        $officer->license_id = $this->license_id;
        $officer->save();

        $this->reset(['name', 'license_id']);
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
            $this->Edit['license_id'] = $officer->license_id;
        }
    }

    public function update()
    {
        $officer = Officer::find($this->idEditable);

        if ($officer) {
            $officer->update([
                'name' => $this->Edit['name'],
                'license_id' => $this->Edit['license_id'],
            ]);

            $this->reset(['Edit', 'idEditable', 'modalE']);
        }
    }
}
