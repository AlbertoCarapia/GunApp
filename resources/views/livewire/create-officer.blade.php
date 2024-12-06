<div>
    <div class="mb-4 flex justify-between">
        <!-- Input para búsqueda -->
        <x-input name="search-category" placeholder="Busqueda" wire:model.live='search' />

        <!-- Botón para abrir modal de creación -->
        <button
            class="ml-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-gray-700"
            wire:click="$set('modalC', true)">
            Crear Oficial
        </button>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Nombre</th>
                    <th class="border px-4 py-2">Licencias</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($officers as $officer)
                    <tr>
                        <td class="border px-4 py-2">{{ $officer->id }}</td>
                        <td class="border px-4 py-2">{{ $officer->name }}</td>
                        <td class="border px-4 py-2">
                            {{ $officer->licenses->pluck('name')->join(', ') ?? 'N/A' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <!-- Botón editar -->
                            <button
                                class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                wire:click="edit({{ $officer->id }})">
                                Editar
                            </button>
                            <!-- Botón eliminar -->
                            <button
                                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                wire:click="delete({{ $officer->id }})">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4">No hay oficiales registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $officers->links() }}
    </div>

    <!-- Modal Crear -->
    @if ($modalC)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
                <h2 class="text-lg font-bold mb-4">Crear Nuevo Oficial</h2>
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
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Tipos de Licencia</label>
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        @foreach ($licenses as $license)
                            <label class="inline-flex items-center">
                                <input
                                    type="checkbox"
                                    value="{{ $license->id }}"
                                    wire:model="license_ids"
                                    class="form-checkbox h-5 w-5 text-blue-600"
                                    required
                                />
                                <span class="ml-2 text-gray-700">{{ $license->name }}</span>
                            </label>
                        @endforeach
                    </div>
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
                <h2 class="text-lg font-bold mb-4">Editar Oficial</h2>
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
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Tipos de Licencia</label>
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        @foreach ($licenses as $license)
                            <label class="inline-flex items-center">
                                <input
                                    type="checkbox"
                                    value="{{ $license->id }}"
                                    wire:model="Edit.license_ids"
                                    class="form-checkbox h-5 w-5 text-blue-600"
                                    required
                                />
                                <span class="ml-2 text-gray-700">{{ $license->name }}</span>
                            </label>
                        @endforeach
                    </div>
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
