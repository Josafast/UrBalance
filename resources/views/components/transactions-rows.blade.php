@foreach ($transactions as $transaction)
    <tr class="transaction-row">
        <td style="order:1;"><input type="text" value="{{ $transaction->name }}"></td>
        <td style="order:2;">{{ number_format($transaction->quantity/100, 2).$sign }}</td>
        <td style="order:3;"><span style="background-color: var(--{{ $transaction->category->type->color }})">{{ __('transactions.types.'.strtolower($transaction->category->type->name)) }}</span></td>
        <td style="color: var(--{{ $transaction->status ? 'green' : 'red' }}); order: 4;">{{ $transaction->status ? __('transactions.state.done') : __('transactions.state.undone') }}</td>
        <td style="order: 5;"><span style="background-color: var(--{{ $transaction->category->color }})">{{ __('transactions.categories.'.strtolower($transaction->category->name)) }}</span></td>
        <td style="order: 6;">{{ date_format(new Datetime($transaction->date), 'Y-m-d') }}</td>
        <td style="order: 7;">
            <form action="{{ route('transactions.edit', $transaction->id) }}" method="get">
                <input type="submit" value="✏️" style="border: none; font-size: 1.1em; cursor: pointer;">
            </form>
        </td>
        <td style="order: 8;">
            <form action="{{ route('transactions.destroy', $transaction->id) }}" class="form" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" value="🗑️" style="border: none; font-size: 1.1em; cursor: pointer;">
            </form>
        </td>
        <td style="order: 9;">
            <form action="{{ route('transactions.notes') }}" class="form" style="padding: 0; background-color: transparent; border-radius: none; width: min-content; height: min-content; width: min-content;" method="POST">
                @csrf
                <label for="id" style="width: 0;">
                    <input type="hidden" name="id" value="{{ $transaction->id }}">
                </label>
                <input type="submit" value="👁️" style="border: none; font-size: 1.1em; cursor: pointer; margin: -30px 0 0; position: relative; top: 0; left: 0; background-color: transparent; border-radius: none; padding: 0px;">
            </form>
        </td>
    </tr>
@endforeach