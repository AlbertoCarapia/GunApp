<div>
    <h1>Registrar Entrega</h1>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="registerDelivery">
        <div>
            <label for="officer_id">Oficial</label>
            <select wire:model="officer_id" id="officer_id" required>
                <option value="">Seleccione un oficial</option>
                @foreach ($officers as $officer)
                    <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="weapon_id">Arma</label>
            <select wire:model="weapon_id" id="weapon_id" required>
                <option value="">Seleccione un arma</option>
                @foreach ($weapons as $weapon)
                    <option value="{{ $weapon->id }}">{{ $weapon->code }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="magazine_id">Cargador</label>
            <select wire:model="magazine_id" id="magazine_id" required>
                <option value="">Seleccione un cargador</option>
                @foreach ($magazines as $magazine)
                    <option value="{{ $magazine->id }}">{{ $magazine->code }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Registrar</button>
    </form>
</div>
