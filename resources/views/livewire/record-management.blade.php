<div>
    <div class="mb-4 flex justify-between">
        <h2 class="text-xl font-semibold">Records con más de 12 horas</h2>
    </div>

    <!-- Mensaje de confirmación -->
    @if ($message)
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ $message }}
        </div>
    @endif

    <!-- Tabla de Records -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Código de Arma</th>
                    <th class="border px-4 py-2">Código de Cargador</th>
                    <th class="border px-4 py-2">Fecha de Emisión</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td class="border px-4 py-2">{{ $record->id }}</td>
                        <td class="border px-4 py-2">{{ $record->weapon->code }}</td>
                        <td class="border px-4 py-2">{{ $record->magazine->code }}</td>
                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($record->issue_date)->diffForHumans() }}</td>
                        <td class="border px-4 py-2 text-center">
                            @if ($record->delivered)
                                <span class="bg-green-500 text-white px-2 py-1 rounded">Entregado</span>
                            @else
                                <button
                                    class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                                    wire:click="markAsDelivered({{ $record->id }})">
                                    Marcar como Entregado
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">No hay records con más de 12 horas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
