<?php

namespace App\Livewire;

use App\Models\Record;
use App\Models\Weapon;
use App\Models\Magazine;
use App\Models\Officer;
use Carbon\Carbon;
use Livewire\Component;

class DeliveryComponent extends Component
{
    public $officer_id;
    public $weapon_id;
    public $magazine_id;

    public function registerDelivery()
    {
        // Validar los datos ingresados
        $this->validate([
            'officer_id' => 'required|exists:officers,id',
            'weapon_id' => 'required|exists:weapons,id',
            'magazine_id' => 'required|exists:magazines,id',
        ]);

        // Obtener datos relacionados
        $officer = Officer::find($this->officer_id);
        $weapon = Weapon::find($this->weapon_id);

        // Validar que el tipo de licencia del oficial coincida con el tipo de arma
        if ($officer->license_id !== $weapon->type_id) {
            session()->flash('error', 'El tipo de licencia del oficial no coincide con el tipo de arma.');
            return;
        }

        // Crear un nuevo registro de entrega
        $record = Record::create([
            'officer_id' => $this->officer_id,
            'weapon_id' => $this->weapon_id,
            'magazine_id' => $this->magazine_id,
            'issue_date' => now(),
        ]);

        // Actualizar el estado del arma y del cargador a "en entrega"
        $weapon->update(['in_stock' => 'en entrega']);
        Magazine::where('id', $this->magazine_id)->update(['in_stock' => 'en entrega']);

        // Programar el cambio de estado a "pendiente" en 12 horas
        $this->schedulePendingStatus($record);

        session()->flash('message', 'Entrega registrada correctamente.');
    }

    protected function schedulePendingStatus($record)
    {
        // Usar un job o tarea programada para actualizar el estado en 12 horas
        \Illuminate\Support\Facades\Queue::later(now()->addHours(12), function () use ($record) {
            $weapon = Weapon::find($record->weapon_id);
            $magazine = Magazine::find($record->magazine_id);

            if ($weapon) {
                $weapon->update(['in_stock' => 'pendiente']);
            }

            if ($magazine) {
                $magazine->update(['in_stock' => 'pendiente']);
            }
        });
    }

    public function render()
    {
        return view('livewire.delivery-component', [
            'officers' => Officer::all(),
            'weapons' => Weapon::where('in_stock', '!=', 'en entrega')->get(),
            'magazines' => Magazine::where('in_stock', '!=', 'en entrega')->get(),
        ]);
    }
}
