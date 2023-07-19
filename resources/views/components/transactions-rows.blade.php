@foreach ($transactions as $transaction)
    <tr>
        <td><input type="text" value="{{ $transaction->name }}"></td>
        <td><span style="background-color: var(--{{ $transaction->category->type->color }})">{{ __('transactions.types.'.strtolower($transaction->category->type->name)) }}</span></td>
        <td>{{ number_format($transaction->quantity/100, 2).$sign }}</td>
        <td><span style="background-color: var(--{{ $transaction->category->color }})">{{ __('transactions.categories.'.strtolower($transaction->category->name)) }}</span></td>
        <td style="color: var(--{{ $transaction->status ? 'green' : 'red' }});">{{ $transaction->status ? __('transactions.state.done') : __('transactions.state.undone') }}</td>
        <td>{{ date_format(new Datetime($transaction->created_at), 'Y-m-d') }}</td>
        <td>
            <form action="{{ route('transactions.edit', $transaction->id) }}" method="get">
                @csrf
                <input type="submit" value="✏️" style="border: none; font-size: 1.1em; cursor: pointer;">
            </form>
        </td>
        <td>
            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" value="🗑️" style="border: none; font-size: 1.1em; cursor: pointer;">
            </form>
        </td>
    </tr>    
@endforeach