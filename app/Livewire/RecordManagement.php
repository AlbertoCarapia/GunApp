<?php

namespace App\Livewire;

use Livewire\Component; // Clase base de los componentes Livewire.
use App\Models\Record; // Modelo que representa los registros generales.
use App\Models\Magazine; // Modelo que representa los registros de cargadores.
use App\Models\Weapon; // Modelo que representa las armas.
use Carbon\Carbon; // Biblioteca para manejar fechas y horas en PHP.

class RecordManagement extends Component
{
    public $records = []; // Variable para almacenar los registros obtenidos.
    public $message = ''; // Variable para almacenar mensajes de estado o error.

    /**
     * Método que se ejecuta al inicializar el componente.
     */
    public function mount()
    {
        // Cargar los registros cuya fecha de emisión sea mayor a 12 horas.
        $this->loadRecords();
    }

    /**
     * Cargar registros con una antigüedad mayor a 12 horas.
     */
    public function loadRecords()
    {
        // Obtener los registros que cumplen con el criterio de antigüedad.
        // Se utiliza la relación con `weapon` y `magazine` para cargar datos relacionados.
        $this->records = Record::with(['weapon', 'magazine'])
            ->where('issue_date', '<', Carbon::now()->subMinutes(720)) // Comparar con la fecha/hora actual menos 12 horas.
            ->get();

        // Añadir una propiedad 'delivered' a cada registro que indica si ambos elementos están entregados.
        foreach ($this->records as $record) {
            $record->delivered = $record->weapon->in_stock === 'Entregado' && $record->magazine->in_stock === 'Entregado';
        }
    }

    /**
     * Marcar un registro como entregado actualizando el estado de su arma y revista.
     *
     * @param int $recordId ID del registro a actualizar.
     */
    public function markAsDelivered($recordId)
    {
        // Buscar el registro por su ID.
        $record = Record::find($recordId);

        if ($record) {
            // Actualizar el estado del cargador (magazine) a 'Entregado'.
            $magazine = $record->magazine;
            $magazine->in_stock = 'Entregado';
            $magazine->save();

            // Actualizar el estado del arma (weapon) a 'Entregado'.
            $weapon = $record->weapon;
            $weapon->in_stock = 'Entregado';
            $weapon->save();

            // Mostrar un mensaje de confirmación.
            $this->message = 'El estado de la revista y el arma ha sido actualizado a "Entregado".';

            // Recargar los registros para reflejar los cambios.
            $this->loadRecords();
        } else {
            // Mostrar un mensaje de error si el registro no fue encontrado.
            $this->message = 'Registro no encontrado.';
        }
    }

    /**
     * Renderizar la vista asociada al componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Retornar la vista con las variables necesarias.
        return view('livewire.record-management', [
            'records' => $this->records, // Registros a mostrar.
            'message' => $this->message, // Mensaje de estado.
        ]);
    }
}
