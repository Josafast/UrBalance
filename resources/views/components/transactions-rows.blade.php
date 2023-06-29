@foreach ($transactions as $transaction)
    <tr>
        <td><input type="text" value="{{ $transaction->name }}"></td>
        <td><span style="background-color: var(--{{ $transaction->category->type->color }})">{{ $transaction->category->type->name }}</span></td>
        <td>{{ $transaction->quantity.$sign }}</td>
        <td><span style="background-color: var(--{{ $transaction->category->color }})">{{ $transaction->category->name }}</span></td>
        <td style="color: var(--{{ $transaction->status ? 'green' : 'red' }})">{{ $transaction->status ? 'Done' : 'Undone' }}</td>
        <td>{{ date_format(new Datetime($transaction->created_at), 'Y-m-d') }}</td>
        <td></td>
    </tr>    
@endforeach