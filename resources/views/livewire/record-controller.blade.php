<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-10">Gestión de Registros</h1>

    <!-- Formulario para crear/editar un registro -->
    <div class="bg-white shadow-md rounded p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">{{ $record_id ? 'Editar Registro' : 'Crear Nuevo Registro' }}</h2>

        @if (session()->has('message'))
            <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Oficial -->
            <div>
                <label for="officer" class="block font-medium">Oficial</label>
                <select wire:model="officer_id" id="officer" class="border-gray-300 rounded w-full">
                    <option value="">Seleccionar Oficial</option>
                    @foreach ($officers as $officer)
                        <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                    @endforeach
                </select>
                @error('officer_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Arma -->
            <div>
                <label for="weapon" class="block font-medium">Arma</label>
                <select wire:model="weapon_id" id="weapon" class="border-gray-300 rounded w-full">
                    <option value="">Seleccionar Arma</option>
                    @foreach ($weapons as $weapon)
                        <option value="{{ $weapon->id }}">{{ $weapon->type->name }} ({{ $weapon->code }})</option>
                    @endforeach
                </select>
                @error('weapon_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Cargador -->
            <div>
                <label for="magazine" class="block font-medium">Cargador</label>
                <select wire:model="magazine_id" id="magazine" class="border-gray-300 rounded w-full">
                    <option value="">Seleccionar Cargador</option>
                    @foreach ($magazines as $magazine)
                        <option value="{{ $magazine->id }}">{{ $magazine->code }}</option>
                    @endforeach
                </select>
                @error('magazine_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

        </div>

        <!-- Botón para crear/editar el registro -->
        <button
            wire:click="{{ $record_id ? 'updateRecord' : 'createRecord' }}"
            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ $record_id ? 'Actualizar Registro' : 'Crear Registro' }}
        </button>

        @if($record_id)
            <!-- Botón para cancelar edición -->
            <button
                wire:click="resetInputFields"
                class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Cancelar
            </button>
        @endif
    </div>

    <!-- Tabla de registros -->
    <div class="bg-white shadow-md rounded p-6">
        <h2 class="text-xl font-semibold mb-4">Listado de Registros</h2>

        <!-- Búsqueda -->
        <input wire:model="search" type="text" placeholder="Buscar..."
            class="mb-4 border-gray-300 rounded w-full px-4 py-2" />

        <!-- Tabla -->
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Oficial</th>
                    <th class="border border-gray-300 px-4 py-2">Arma</th>
                    <th class="border border-gray-300 px-4 py-2">Cargador</th>
                    <th class="border border-gray-300 px-4 py-2">Fecha de Emisión</th>
                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->officer->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->weapon->type->name }} ({{ $record->weapon->code }})</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->magazine->code }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->issue_date }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <button
                                wire:click="editRecord({{ $record->id }})"
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                Editar
                            </button>
                            <button
                                wire:click="deleteRecord({{ $record->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                            No se encontraron registros.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $records->links() }}
        </div>
    </div>
</div>
