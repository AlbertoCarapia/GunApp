<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Delivery;

class CreateDelivery extends Component
{
    use WithPagination;

    public $record_id, $date;
    public $modalC = false;
    public $modalE = false;
    public $idEditable;
    public $Edit = [
        'id' => '',
        'record_id' => '',
        'date' => '',
    ];
    public $search = '';

    public function render()
    {
        $deliveries = Delivery::where('record_id', 'like', '%' . $this->search . '%')
                              ->orWhere('date', 'like', '%' . $this->search . '%')
                              ->paginate(5);

        return view('livewire.create-delivery', [
            'deliveries' => $deliveries
        ]);
    }

    public function save()
    {
        $delivery = new Delivery();
        $delivery->record_id = $this->record_id;
        $delivery->date = $this->date;
        $delivery->save();

        $this->reset(['record_id', 'date']);
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
        $delivery = Delivery::find($id);
        if ($delivery) {
            $delivery->delete();
        }
    }

    public function edit($id)
    {
        $this->modalE = true;
        $delivery = Delivery::find($id);

        if ($delivery) {
            $this->idEditable = $delivery->id;
            $this->Edit['id'] = $delivery->id;
            $this->Edit['record_id'] = $delivery->record_id;
            $this->Edit['date'] = $delivery->date;
        }
    }

    public function update()
    {
        $delivery = Delivery::find($this->idEditable);

        if ($delivery) {
            $delivery->update([
                'record_id' => $this->Edit['record_id'],
                'date' => $this->Edit['date'],
            ]);

            $this->reset(['Edit', 'idEditable', 'modalE']);
        }
    }
}
