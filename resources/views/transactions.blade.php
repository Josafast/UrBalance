<x-app-layout title="{{ __('titles.transactions.index') }}">
  <section style="flex-direction: column">
    <h1 style="margin: 0 0 10px; font-weight: bold; font-size: 2.2em; color: #545454">{{ __('validation_fields.titles.filtered') }}</h1>
    <form action="{{ route('transactions.index') }}" method="get" class="form transactions_form" style="margin: 0; font-size: .9em;">
      <div style="position: relative; display: grid; grid-template-columns: repeat(2, min-content); grid-template-rows: repeat(2, 44.5px); grid-column-gap: 10px">
        <h2>{{ __('query_fields.type') }}:</h2>
        <label for="type" style="width: min-content">
            <select name="type" style="width: min-content">
              <option value="">{{ __('transactions.types.none') }}</option>
              <option value="2" @php if (array_key_exists('type', request()->query())){
                if (request()->query()['type'] == '2'){
                  echo 'selected';
                } 
              } @endphp>{{ __('transactions.types.spend') }}</option>
              <option value="1"  @php if (array_key_exists('type', request()->query())){
                if (request()->query()['type'] == '1'){
                  echo 'selected';
                } 
              } @endphp>{{ __('transactions.types.entrance') }}</option>
              <option value="3"  @php if (array_key_exists('type', request()->query())){
                if (request()->query()['type'] == '3'){
                  echo 'selected';
                } 
              } @endphp>{{ __('transactions.types.saving') }}</option>
            </select>
        </label>
        <h2>{{ __('query_fields.state') }}:</h2>
        <label for="state" style="width: min-content">
            <select name="state" style="width: min-content">
              <option value="">{{ __('transactions.types.none') }}</option>
              <option value="true" @php if (array_key_exists('state', request()->query())){
                if (request()->query()['state'] == 'true'){
                  echo 'selected';
                } 
              } @endphp>{{ __('transactions.state.done') }}</option>
              <option value="false" @php if (array_key_exists('state', request()->query())){
                if (request()->query()['state'] == 'false'){
                  echo 'selected';
                } 
              } @endphp>{{ __('transactions.state.undone') }}</option>
            </select>
        </label>
      </div>
      <div style="position: relative; display: grid; grid-template-columns: repeat(2, min-content); grid-template-rows: repeat(2, 44.5px); grid-column-gap: 10px; padding-top: 2px">
        <h2>{{ __('query_fields.base') }}: </h2>
        <label for="base" style="width: min-content">
          <input type="number" name="base" value="@php if (array_key_exists('base', request()->query())) echo request()->query()['base']; @endphp">
        </label>
        <h2>{{ __('query_fields.limit') }}: </h2>
        <label for="limit" style="width: min-content">
          <input type="number" name="limit" value="@php if (array_key_exists('limit', request()->query())) echo request()->query()['limit']; @endphp">
        </label>
      </div>
      <div style="position: relative; display: grid; grid-template-columns: repeat(2, min-content); grid-template-rows: repeat(2, 44.5px); grid-column-gap: 10px">
        <h2>{{ __('query_fields.since') }}: </h2>
        <label for="since" style="width: min-content">
          <input type="date" name="since" id="dateSINCE" value="@php if (array_key_exists('since', request()->query())) echo request()->query()['since']; @endphp">
        </label>
        <h2>{{ __('query_fields.until') }}: </h2>
        <label for="until" style="width: min-content">
          <input type="date" name="until" id="dateUNTIL" value="@php if (array_key_exists('until', request()->query())) echo request()->query()['until']; @endphp">
        </label>
      </div>
      <input type="submit" value="{{ __('validation_fields.buttons.filter') }}" id="submit" style="position: relative; display: none;">
      <script>
        document.querySelector('.transactions_form').addEventListener('change',()=>document.getElementById('submit').style.display = "block");
      </script>
    </form>
  </section>
  <section class="transactions-table">
    <table>
      <thead>
        <tr>
          <th>{{ __('transactions.table.name') }}</th>
          <th>{{ __('transactions.table.type') }}</th>
          <th>{{ __('transactions.table.quantity') }}</th>
          <th>{{ __('transactions.table.category') }}</th>
          <th>{{ __('transactions.table.state') }}</th>
          <th>{{ __('transactions.table.date') }}</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <x-transactions-rows />
      </tbody>
    </table>
  </section>
</x-app-layout>