<!-- resources/views/livewire/live-delivery.blade.php -->
<div>
    <div class="mb-4 flex justify-between">
        <input
            type="text"
            wire:model.debounce.500ms="search"
            placeholder="Buscar entregas..."
            class="px-4 py-2 border rounded w-full max-w-md"
        />

        <button
            class="ml-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-gray-700"
            wire:click="$set('modalC', true)">
            Crear Entrega
        </button>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Record ID</th>
                    <th class="border px-4 py-2">Fecha</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($deliveries as $delivery)
                    <tr>
                        <td class="border px-4 py-2">{{ $delivery->id }}</td>
                        <td class="border px-4 py-2">{{ $delivery->record_id }}</td>
                        <td class="border px-4 py-2">{{ $delivery->date }}</td>
                        <td class="border px-4 py-2 text-center">
                            <button
                                class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                wire:click="edit({{ $delivery->id }})">
                                Editar
                            </button>
                            <button
                                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                wire:click="delete({{ $delivery->id }})">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4">No hay entregas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $deliveries->links() }}
    </div>

    <!-- Modal Crear -->
    @if ($modalC)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
                <h2 class="text-lg font-bold mb-4">Crear Nueva Entrega</h2>
                <div>
                    <label for="record_id" class="block text-sm font-medium text-gray-700">Record ID</label>
                    <input
                        type="text"
                        id="record_id"
                        wire:model="record_id"
                        class="mt-1 p-2 border rounded w-full"
                    />
                </div>
                <div class="mt-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input
                        type="date"
                        id="date"
                        wire:model="date"
                        class="mt-1 p-2 border rounded w-full"
                    />
                </div>
                <div class="mt-4 flex justify-end">
                    <button
                        class="px-4 py-2 bg-gray-300 rounded mr-2 hover:bg-gray-400"
                        wire:click="$set('modalC', false)">
                        Cancelar
                    </button>
                    <button
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        wire:click="save">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Editar -->
    @if ($modalE)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
                <h2 class="text-lg font-bold mb-4">Editar Entrega</h2>
                <div>
                    <label for="edit_record_id" class="block text-sm font-medium text-gray-700">Record ID</label>
                    <input
                        type="text"
                        id="edit_record_id"
                        wire:model="Edit.record_id"
                        class="mt-1 p-2 border rounded w-full"
                    />
                </div>
                <div class="mt-4">
                    <label for="edit_date" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input
                        type="date"
                        id="edit_date"
                        wire:model="Edit.date"
                        class="mt-1 p-2 border rounded w-full"
                    />
                </div>
                <div class="mt-4 flex justify-end">
                    <button
                        class="px-4 py-2 bg-gray-300 rounded mr-2 hover:bg-gray-400"
                        wire:click="$set('modalE', false)">
                        Cancelar
                    </button>
                    <button
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                        wire:click="update">
                        Actualizar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
