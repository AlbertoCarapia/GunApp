<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LType;

class CreateLType extends Component
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
        $licenseTypes = LType::where('name', 'like', '%' . $this->search . '%')
                             ->paginate(5);

        return view('livewire.create-l-type', [
            'licenseTypes' => $licenseTypes,
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        LType::create([
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
        $licenseType = LType::find($id);
        if ($licenseType) {
            $licenseType->delete();
        }
    }

    public function edit($id)
    {
        $this->modalE = true;
        $licenseType = LType::find($id);

        if ($licenseType) {
            $this->idEditable = $licenseType->id;
            $this->Edit['id'] = $licenseType->id;
            $this->Edit['name'] = $licenseType->name;
        }
    }

    public function update()
    {
        $this->validate([
            'Edit.name' => 'required|string|max:255',
        ]);

        $licenseType = LType::find($this->idEditable);

        if ($licenseType) {
            $licenseType->update([
                'name' => $this->Edit['name'],
            ]);

            $this->reset(['Edit', 'idEditable', 'modalE']);
        }
    }
}
