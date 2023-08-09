<div class="float create_balance" style="display: none;">
    <form action="{{ route('balance.create') }}" id="balance-create" class="form form_styles" method="post">
        @csrf
        @if (!request()->routeIs('register.view'))
            <h2>{{ __('validation_fields.titles.create_balance') }}</h2>
        @endif
        <span class="close" id="closeFloatCreate">
            <img src="{{ asset('img/close.svg') }}" alt="close-icon" style="pointer-events: none; user-select: none;">
        </span>
        <label for="initial" class="balance-label">
            <h4>{{ __('validation_fields.titles.select_initial_value') }}</h4>
            <input type="number" required min="0.01" step="0.01" value="0.00" name="initial" class="number">
        </label>
        <label for="exchange_id" class="balance-label">
            <h4>{{ __('validation_fields.titles.select_exchange') }}</h4>
            <select name="exchange_id" style="width: min-content">
                @foreach (App\Models\Exchange::all() as $exchange)
                    @if (!auth()->check() || request()->user()->balance->where('exchange_id', $exchange->id)->count() < 1)
                        <option value="{{ $exchange->id }}">{{ __('exchange.'.strtolower($exchange->name)) }}</option>
                    @endif
                @endforeach
            </select>
        </label>
        <input type="submit" value="{{ request()->routeIs('register.view') ? __('validation_fields.buttons.register') : __('validation_fields.buttons.create') }}" style="margin: 10px 0 0 auto; position: relative;">
    </form>
    <script>
        document.getElementById('closeFloatCreate').addEventListener('click',(e)=>{
            e.target.parentElement.parentElement.style.display = "none";
        });
    </script>
</div>