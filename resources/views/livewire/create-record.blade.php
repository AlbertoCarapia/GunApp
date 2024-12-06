<div>
    <!-- Barra de búsqueda y botón de crear -->
    <div class="mb-4 flex justify-between">
        <input
            type="text"
            wire:model.debounce.500ms="search"
            placeholder="Buscar registros..."
            class="px-4 py-2 border rounded w-full max-w-md"
        />

        <button
            class="ml-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-gray-700"
            wire:click="$set('modalC', true)">
            Crear Registro
        </button>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Oficial</th>
                    <th class="border px-4 py-2">Arma</th>
                    <th class="border px-4 py-2">Revista</th>
                    <th class="border px-4 py-2">Fecha de Emisión</th>
                    <th class="border px-4 py-2">Fecha de Devolución</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td class="border px-4 py-2">{{ $record->id }}</td>
                        <td class="border px-4 py-2">{{ $record->officer->name }}</td>
                        <td class="border px-4 py-2">{{ $record->weapon->name }}</td>
                        <td class="border px-4 py-2">{{ $record->magazine->code }}</td>
                        <td class="border px-4 py-2">{{ $record->issue_date }}</td>
                        <td class="border px-4 py-2">{{ $record->return_date }}</td>
                        <td class="border px-4 py-2 text-center">
                            <button
                                class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                wire:click="edit({{ $record->id }})">
                                Editar
                            </button>
                            <button
                                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                wire:click="delete({{ $record->id }})">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4">No hay registros disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $records->links() }}
    </div>

    <!-- Modal Crear -->
    @if ($modalC)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
                <h2 class="text-lg font-bold mb-4">Crear Nuevo Registro</h2>
                <div class="mb-4">
                    <label for="officer_id" class="block text-sm font-medium text-gray-700">Oficial</label>
                    <select id="officer_id" wire:model="officer_id" class="mt-1 p-2 border rounded w-full">
                        <option value="">Seleccione un oficial</option>
                        @foreach ($officers as $officer)
                            <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="weapon_id" class="block text-sm font-medium text-gray-700">Arma</label>
                    <select id="weapon_id" wire:model="weapon_id" class="mt-1 p-2 border rounded w-full">
                        <option value="">Seleccione un arma</option>
                        @foreach ($weapons as $weapon)
                            <option value="{{ $weapon->id }}">{{ $weapon->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="magazine_id" class="block text-sm font-medium text-gray-700">Revista</label>
                    <select id="magazine_id" wire:model="magazine_id" class="mt-1 p-2 border rounded w-full">
                        <option value="">Seleccione una revista</option>
                        @foreach ($magazines as $magazine)
                            <option value="{{ $magazine->id }}">{{ $magazine->code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="issue_date" class="block text-sm font-medium text-gray-700">Fecha de Emisión</label>
                    <input type="date" id="issue_date" wire:model="issue_date" class="mt-1 p-2 border rounded w-full" />
                </div>
                <div class="mb-4">
                    <label for="return_date" class="block text-sm font-medium text-gray-700">Fecha de Devolución</label>
                    <input type="date" id="return_date" wire:model="return_date" class="mt-1 p-2 border rounded w-full" />
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
                <h2 class="text-lg font-bold mb-4">Editar Registro</h2>
                <!-- Campos para editar similar a crear -->
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
