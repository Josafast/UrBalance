<div class="float" style="display: none;" id="create_balance">
    <form action="{{ route('balance.create') }}" id="balance-create" class="form" method="post">
        @csrf
        <span class="close" id="closeFloatCreate">
            <img src="{{ asset('img/close.svg') }}" alt="close-icon" style="pointer-events: none; user-select: none;">
        </span>
        <label for="initial" class="balance-label">
            <h4>Selecciona el valor inicial de tu cuenta:</h4>
            <input type="number" required name="initial" class="number">
        </label>
        <label for="exchange_id" class="balance-label">
            <h4>Selecciona la tasa de cambio</h4>
            <select name="exchange_id" style="width: min-content">
                @foreach (App\Models\Exchange::all() as $exchange)
                    @if (!auth()->check() || request()->user()->balance->where('exchange_id', $exchange->id)->count() < 1)
                        <option value="{{ $exchange->id }}">{{ $exchange->name }}</option>
                    @endif
                @endforeach
            </select>
        </label>
        <input type="submit" value="{{ request()->routeIs('register.view') ? 'Registrarse' : 'Crear' }}" style="margin: 10px 0 0 auto; position: relative;">
    </form>
    <script>
        document.getElementById('closeFloatCreate').addEventListener('click',(e)=>{
            e.target.parentElement.parentElement.style.display = "none";
        });
    </script>
</div>