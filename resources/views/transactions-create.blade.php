<x-app-layout title="{{ isset($transaction) ? __('titles.transactions.modify') : __('titles.transactions.create') }}">
  <form action="{{ isset($transaction) ? route('transactions.updater') : route('transactions.store') }}" method="POST" class="form transaction_form">
    @csrf 
    @method( isset($transaction) ? 'PUT' : 'POST')
    @if (isset($transaction))
      <input type="hidden" name="id" value="{{ $transaction->id }}">
    @endif
    <div style="display: grid; grid-gap: 0; grid-template-columns: 1fr max-content; grid-template-rows: min-content; height: min-content;">
      <label for="name">
        <input type="text" name="name" required placeholder="{{ __('transactions.fields.new_transaction') }}" 
        @if (isset($transaction))
          value="{{ $transaction->name }}"
        @endif>
      </label>
      <label for="quantity">
        <span class="transaction_span">
          <input type="number" step="0.01" min="0.01" name="quantity" id="quantity-input" value="{{ isset($transaction) ? number_format($transaction->quantity/100, 2, ".", "") : '0.00' }}" class="number" style="height: min-content">&nbsp;{{ App\Models\Exchange::where('id', session()->get('main'))->first()->sign }}
        </span>
      </label>
    </div>
    <div style="padding: 5px 0; display: flex; gap: 10px; height: min-content" class="transaction_options">
        @php $types = App\Models\Type::all()->load('categories'); @endphp
        <select style="width: min-content" class="type-selector">
          <option value="|#333">{{ __('transactions.table.type') }}</option>
          @foreach($types as $type)
            <option value="{{ $type->name }}|var(--{{ $type->color }})" 
              @if (isset($transaction))
                @if ($type->id == $transaction->category->type_id)
                  selected
                @endif
              @endif>{{ __('transactions.types.'.strtolower($type->name)) }}</option>
          @endforeach
        </select>
      <label for="status" style="width: min-content;">
        <select name="status" required style="width: min-content">
          <option value="">{{ __('transactions.table.state') }}</option>
          <option value="true" 
          @if (isset($transaction))
            @if (boolval($transaction->status))
              selected
            @endif
          @endif>{{ __('transactions.state.done') }}</option>
          <option value="false"
          @if (isset($transaction))
            @if (!boolval($transaction->status))
              selected
            @endif
          @endif>{{ __('transactions.state.undone') }}</option>
        </select>
      </label>
      <label for="category_id" style="width: min-content;">
        <select name="category_id" required style="width: min-content" class="category-selector-main">
          <option value="">{{ __('transactions.table.category') }}</option>
          @foreach($types as $type)
            <optgroup label="{{ __('transactions.types.'.strtolower($type->name)) }}" id="{{ $type->name }}" class="category-selector">
            @foreach($type->categories as $category)
              <option value="{{ $category->id }}"
                @if (isset($transaction))
                  @if ($category->id == $transaction->category_id)
                    selected
                  @endif
                @endif>{{ __('transactions.categories.'.strtolower($category->name)) }}</option>
            @endforeach
            </optgroup>
          @endforeach
        </select>
      </label>
      <label for="date">
        <input type="date" name="date" required value="{{ date_format(new DateTime(isset($transaction) ? $transaction->date : ''), "Y-m-d") }}">
      </label>
    </div>
    <div style="height: 100%; display: flex; flex-direction: column; flex-wrap: nowrap !important; margin-top: auto;">
      <label for="notes" style="height: 100%">
        <textarea name="notes" placeholder="{{ __('transactions.fields.notes') }}">@if(isset($transaction)){{trim($transaction->notes)}}@endif</textarea>
      </label>
      <input type="submit" value="{{ isset($transaction) ? __('transactions.fields.modify_transaction') : __('transactions.fields.create_transaction') }}" style="margin-top: auto;" class="transaction_submit">
    </div>
  </form>
  @vite(['resources/js/transactions-create.js'])
</x-app-layout>