<div>
    <div class="mb-4 flex justify-between">
        <x-input name="search-category" placeholder="Busqueda" wire:model.live='search' />

        <button
            class="ml-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-gray-700"
            wire:click="$set('modalC', true)">
            Crear Cargador
        </button>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Código</th>
                    <th class="border px-4 py-2">ID de Arma</th>
                    <th class="border px-4 py-2">En Stock</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($magazines as $magazine)
                    <tr>
                        <td class="border px-4 py-2">{{ $magazine->id }}</td>
                        <td class="border px-4 py-2">{{ $magazine->code }}</td>
                        <td class="border px-4 py-2">{{ $magazine->weapon_id }}</td>
                        <td class="border px-4 py-2">{{ $magazine->in_stock }}</td>
                        <td class="border px-4 py-2 text-center">
                            <button
                                class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                wire:click="edit({{ $magazine->id }})">
                                Editar
                            </button>
                            <button
                                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                wire:click="delete({{ $magazine->id }})">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">No hay cargadores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $magazines->links() }}
    </div>

    <!-- Modal Crear -->
    @if ($modalC)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
                <h2 class="text-lg font-bold mb-4">Crear Nuevo Cargador</h2>
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Código</label>
                    <input
                        type="text"
                        id="code"
                        wire:model="code"
                        class="mt-1 p-2 border rounded w-full"
                        required
                    />
                </div>
                <div class="mt-4">
                    <label for="weapon_id" class="block text-sm font-medium text-gray-700">ID de Arma</label>
                    <input
                        type="text"
                        id="weapon_id"
                        wire:model="weapon_id"
                        class="mt-1 p-2 border rounded w-full"
                        required
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
                <h2 class="text-lg font-bold mb-4">Editar Cargador</h2>
                <div>
                    <label for="edit_code" class="block text-sm font-medium text-gray-700">Código</label>
                    <input
                        type="text"
                        id="edit_code"
                        wire:model="Edit.code"
                        class="mt-1 p-2 border rounded w-full"
                        required
                    />
                </div>
                <div class="mt-4">
                    <label for="edit_weapon_id" class="block text-sm font-medium text-gray-700">ID de Arma</label>
                    <input
                        type="text"
                        id="edit_weapon_id"
                        wire:model="Edit.weapon_id"
                        class="mt-1 p-2 border rounded w-full"
                        required
                    />
                </div>
                <div class="mt-4">
                    <label for="edit_in_stock" class="block text-sm font-medium text-gray-700">En Stock</label>
                    <input
                        type="text"
                        id="edit_in_stock"
                        wire:model="Edit.in_stock"
                        class="mt-1 p-2 border rounded w-full"
                        required
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
