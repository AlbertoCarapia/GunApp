<?php

namespace App\Livewire;

use App\Models\Record;
use App\Models\Weapon;
use App\Models\Magazine;
use App\Models\Officer;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class RecordController extends Component
{
    use WithPagination;

    public $officer_id, $weapon_id, $magazine_id, $issue_date, $record_id;
    public $search = ''; // Variable para la búsqueda

    // Función para renderizar la vista
    public function render()
    {
        $records = Record::with(['officer', 'weapon', 'magazine'])
            ->whereHas('officer', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('weapon.type', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('magazine', function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%');
            })
            ->orderBy('issue_date', 'desc')
            ->paginate(5); // Paginación

        return view('livewire.record-controller', [
            'officers' => Officer::all(),
            'weapons' => Weapon::where('in_stock', 'disponible')->get(), // Solo armas disponibles
            'magazines' => Magazine::where('in_stock', 'disponible')->get(), // Solo cargadores disponibles
            'records' => $records, // Pasamos los registros a la vista
        ]);
    }


    // Función para editar un registro
    public function editRecord($id)
    {
        $record = Record::findOrFail($id);

        // Establecer los campos con los valores del registro
        $this->record_id = $record->id;
        $this->officer_id = $record->officer_id;
        $this->weapon_id = $record->weapon_id;
        $this->magazine_id = $record->magazine_id;

        // Convertir issue_date a un objeto Carbon (si es necesario) y formatearlo
        $this->issue_date = Carbon::parse($record->issue_date)->format('Y-m-d');
    }

    // Función para crear el record y actualizar los estados
    public function createRecord()
    {
        // Validar los datos de entrada
        $validatedData = Validator::make([
            'officer_id' => $this->officer_id,
            'weapon_id' => $this->weapon_id,
            'magazine_id' => $this->magazine_id,
        ], [
            'officer_id' => 'required|exists:officers,id',
            'weapon_id' => 'required|exists:weapons,id',
            'magazine_id' => 'required|exists:magazines,id',
        ])->validate();

        // Obtener el oficial y el arma seleccionados
        $officer = Officer::find($this->officer_id);
        $weapon = Weapon::find($this->weapon_id);

        // Verificar compatibilidad entre el tipo de licencia del oficial y el tipo de arma
        $weaponType = $weapon->type; // Relación con WeaponType
        $officerLicenses = $officer->licenses; // Relación con LType

        if (!$officerLicenses->contains('id', $weaponType->id)) {
            session()->flash('error', 'El tipo de arma no es compatible con las licencias del oficial.');
            return;
        }

        // Validar que el arma esté disponible
        if ($weapon->in_stock !== 'disponible') {
            session()->flash('error', 'El arma seleccionada no está disponible.');
            return;
        }

        // Establecer la fecha de emisión como la fecha actual
        $validatedData['issue_date'] = now();

        // Crear el registro
        $record = Record::create($validatedData);

        // Actualizar el estado del arma
        $weapon->update(['in_stock' => 'en entrega']);

        // Actualizar el estado del cargador
        $magazine = Magazine::find($this->magazine_id);
        if ($magazine) {
            $magazine->update(['in_stock' => 'en entrega']);
        }

        // Emitir un mensaje de éxito
        session()->flash('message', 'Record creado exitosamente.');

        // Limpiar los campos
        $this->reset();
    }


    // Función para actualizar un record
    public function updateRecord()
    {
        $this->validateFields();

        $record = Record::findOrFail($this->record_id);

        // Actualizar estados previos (si se cambiaron arma o cargador)
        $this->updateStockStates($record->weapon_id, $record->magazine_id, 'disponible');

        // Actualizar el registro
        $record->update($this->getValidatedData());

        // Actualizar los nuevos estados
        $this->updateStockStates($this->weapon_id, $this->magazine_id, 'en entrega');

        session()->flash('message', 'Record actualizado exitosamente.');
        $this->resetInputFields();
    }

    // Función para eliminar un record
    public function deleteRecord($id)
    {
        $record = Record::findOrFail($id);

        // Revertir los estados del arma y el cargador
        $this->updateStockStates($record->weapon_id, $record->magazine_id, 'disponible');

        $record->delete();

        session()->flash('message', 'Record eliminado exitosamente.');
    }

    // Validar los campos
    private function validateFields()
    {
        Validator::make([
            'officer_id' => $this->officer_id,
            'weapon_id' => $this->weapon_id,
            'magazine_id' => $this->magazine_id,
            'issue_date' => $this->issue_date,
        ], [
            'officer_id' => 'required|exists:officers,id',
            'weapon_id' => 'required|exists:weapons,id',
            'magazine_id' => 'required|exists:magazines,id',
            'issue_date' => 'required|date',
        ])->validate();
    }

    // Obtener los datos validados
    private function getValidatedData()
    {
        return [
            'officer_id' => $this->officer_id,
            'weapon_id' => $this->weapon_id,
            'magazine_id' => $this->magazine_id,
            'issue_date' => $this->issue_date,
        ];
    }

    // Actualizar el estado de arma y cargador
    private function updateStockStates($weaponId, $magazineId, $state)
    {
        if ($weaponId) {
            $weapon = Weapon::find($weaponId);
            if ($weapon) {
                $weapon->update(['in_stock' => $state]);
            }
        }

        if ($magazineId) {
            $magazine = Magazine::find($magazineId);
            if ($magazine) {
                $magazine->update(['in_stock' => $state]);
            }
        }
    }

    // Resetear los campos
    private function resetInputFields()
    {
        $this->officer_id = null;
        $this->weapon_id = null;
        $this->magazine_id = null;
        $this->issue_date = null;
        $this->record_id = null;
    }
}
