<div>
    <!-- Barra de búsqueda y botón de crear -->
    <div class="mb-4 flex justify-between">
        <input
            type="text"
            wire:model.debounce.500ms="search"
            placeholder="Buscar tipos de arma..."
            class="px-4 py-2 border rounded w-full max-w-md"
        />

        <button
            class="ml-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-gray-700"
            wire:click="$set('modalC', true)">
            Crear Tipo de Arma
        </button>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Nombre</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($types as $type)
                    <tr>
                        <td class="border px-4 py-2">{{ $type->id }}</td>
                        <td class="border px-4 py-2">{{ $type->name }}</td>
                        <td class="border px-4 py-2 text-center">
                            <button
                                class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                wire:click="edit({{ $type->id }})">
                                Editar
                            </button>
                            <button
                                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                wire:click="delete({{ $type->id }})">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center p-4">No hay tipos de armas registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $types->links() }}
    </div>

    <!-- Modal Crear -->
    @if ($modalC)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
                <h2 class="text-lg font-bold mb-4">Crear Nuevo Tipo de Arma</h2>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
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
                <h2 class="text-lg font-bold mb-4">Editar Tipo de Arma</h2>
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input
                        type="text"
                        id="edit_name"
                        wire:model="Edit.name"
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
