<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Record;
use App\Models\Officer;
use App\Models\Weapon;
use App\Models\Magazine;

class CreateRecord extends Component
{
    use WithPagination;

    public $officer_id, $weapon_id, $magazine_id, $issue_date, $return_date;
    public $modalC = false;
    public $modalE = false;
    public $idEditable;
    public $Edit = [
        'id' => '',
        'officer_id' => '',
        'weapon_id' => '',
        'magazine_id' => '',
        'issue_date' => '',
        'return_date' => '',
    ];
    public $search = '';

    public function render()
    {
        $records = Record::with(['officer', 'weapon', 'magazine'])
    ->whereHas('officer', function ($query) {
        $query->where('name', 'like', '%' . $this->search . '%');
    })
    ->orWhereHas('weapon', function ($query) {
        $query->where('code', 'like', '%' . $this->search . '%');
    })
    ->orWhereHas('magazine', function ($query) {
        $query->where('code', 'like', '%' . $this->search . '%');
    })
    ->paginate(5);


        $officers = Officer::all();
        $weapons = Weapon::all();
        $magazines = Magazine::all();

        return view('livewire.create-record', [
            'records' => $records,
            'officers' => $officers,
            'weapons' => $weapons,
            'magazines' => $magazines,
        ]);
    }

    public function save()
    {
        $record = new Record();
        $record->officer_id = $this->officer_id;
        $record->weapon_id = $this->weapon_id;
        $record->magazine_id = $this->magazine_id;
        $record->issue_date = $this->issue_date;
        $record->return_date = $this->return_date;
        $record->save();

        $this->reset(['officer_id', 'weapon_id', 'magazine_id', 'issue_date', 'return_date']);
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
        $record = Record::find($id);
        if ($record) {
            $record->delete();
        }
    }

    public function edit($id)
    {
        $this->modalE = true;
        $record = Record::find($id);

        if ($record) {
            $this->idEditable = $record->id;
            $this->Edit['id'] = $record->id;
            $this->Edit['officer_id'] = $record->officer_id;
            $this->Edit['weapon_id'] = $record->weapon_id;
            $this->Edit['magazine_id'] = $record->magazine_id;
            $this->Edit['issue_date'] = $record->issue_date;
            $this->Edit['return_date'] = $record->return_date;
        }
    }

    public function update()
    {
        $record = Record::find($this->idEditable);

        if ($record) {
            $record->update([
                'officer_id' => $this->Edit['officer_id'],
                'weapon_id' => $this->Edit['weapon_id'],
                'magazine_id' => $this->Edit['magazine_id'],
                'issue_date' => $this->Edit['issue_date'],
                'return_date' => $this->Edit['return_date'],
            ]);

            $this->reset(['Edit', 'idEditable', 'modalE']);
        }
    }
}
