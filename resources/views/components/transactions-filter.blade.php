@php $count = boolval(count(request()->query())); @endphp

<h1 style="margin: 0 0 10px; font-weight: bold; font-size: 2.2em; color: #545454">
    {{ __('validation_fields.titles.filtered') }}</h1>
<form action="{{ route('transactions.index') }}" method="GET" class="form transactions_form" style="margin: 0; font-size: .9em;">
    <div>
        <h2>{{ __('query_fields.type') }}:</h2>
        <label for="type">
            <select name="type">
                <option value="">{{ __('transactions.types.none') }}</option>
                <option value="2" @if ($count) 
                  @if (request()->query()['type'] == '2') selected @endif
                @endif>
                    {{ __('transactions.types.spend') }}</option>
                <option value="1" @if ($count) 
                  @if (request()->query()['type'] == '1') selected @endif
                @endif>
                    {{ __('transactions.types.entrance') }}</option>
                <option value="3" @if ($count) 
                  @if (request()->query()['type'] == '3') selected @endif
                @endif>
                    {{ __('transactions.types.saving') }}</option>
            </select>
        </label>
        <h2>{{ __('query_fields.state') }}:</h2>
        <label for="state">
            <select name="state">
                <option value="">{{ __('transactions.types.none') }}</option>
                <option value="true" @if ($count) 
                  @if (request()->query()['type'] == 'true') selected @endif
                @endif>
                    {{ __('transactions.state.done') }}</option>
                <option value="false" @if ($count) 
                  @if (request()->query()['type'] == '2') selected @endif
                @endif>
                    {{ __('transactions.state.undone') }}</option>
            </select>
        </label>
    </div>
    <div>
        <h2>{{ __('query_fields.base') }}: </h2>
        <label for="base">
            <input type="number" name="base" min="0" @if ($count) value="{{ request()->query()['base'] }}" @endif>
        </label>
        <h2>{{ __('query_fields.limit') }}: </h2>
        <label for="limit">
            <input type="number" name="limit" min="0" @if ($count) value="{{ request()->query()['limit'] }}" @endif>
        </label>
    </div>
    <div>
        <h2>{{ __('query_fields.since') }}: </h2>
        <label for="since">
            <input type="date" name="since" id="dateSINCE" @if ($count) value="{{ request()->query()['since'] }}" @endif>
        </label>
        <h2>{{ __('query_fields.until') }}: </h2>
        <label for="until">
            <input type="date" name="until" id="dateUNTIL" @if ($count) value="{{ request()->query()['until'] }}" @endif>
        </label>
    </div>
    <input type="submit" value="{{ __('validation_fields.buttons.filter') }}" id="submit"
        style="position: relative; display: none;">
    <script>
        document.querySelector('.transactions_form').addEventListener('change', () => document.getElementById('submit').style.display = "block");
    </script>
</form>
