<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Record;
use App\Models\Magazine;
use App\Models\Weapon;
use Carbon\Carbon;

class RecordManagement extends Component
{
    public $records = [];
    public $message = '';

    public function mount()
    {
        // Cargar las records que llevan más de 12 horas
        $this->loadRecords();
    }

    public function loadRecords()
    {
        // Obtener las records donde la fecha de emisión es mayor a 12 horas
        $this->records = Record::with(['weapon', 'magazine'])
        ->where('issue_date', '<', Carbon::now()->subMinutes(2))
            ->get();

        // Añadir una propiedad 'delivered' a cada record, que será verdadera si ya está entregado
        foreach ($this->records as $record) {
            $record->delivered = $record->weapon->in_stock === 'Entregado' && $record->magazine->in_stock === 'Entregado';
        }
    }

    public function markAsDelivered($recordId)
    {
        // Encontrar la record por ID
        $record = Record::find($recordId);

        if ($record) {
            // Marcar como entregado la revista (Magazine)
            $magazine = $record->magazine;
            $magazine->in_stock = 'Entregado';
            $magazine->save();

            // Marcar como entregado el arma (Weapon)
            $weapon = $record->weapon;
            $weapon->in_stock = 'Entregado';
            $weapon->save();

            // Mensaje de confirmación
            $this->message = 'El estado de la revista y el arma ha sido actualizado a "Entregado".';

            // Recargar las records para reflejar el cambio
            $this->loadRecords();
        } else {
            $this->message = 'Record no encontrado.';
        }
    }

    public function render()
    {
        return view('livewire.record-management', [
            'records' => $this->records,
            'message' => $this->message,
        ]);
    }
}
