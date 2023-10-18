<tr>
    <td class="align-middle">{{ $transaction->email }}</td>
    <td class="align-middle">{{ $transaction->transaction_id }}</td>
    <td class="align-middle">{{ $transaction->payment_method }}</td>
    <td class="align-middle">{{ $transaction->amount }}</td>
    <td class="align-middle">{{ $transaction->description }}</td>
    <td class="align-middle">{{ $transaction->bank }}</td>
    <td class="align-middle">{{Carbon\Carbon::parse($transaction->created_at)->format('d-M-Y  g:i:s A' )}}</td>
    <td class="align-middle">
        <span class="badge badge-lg {{ $transaction->status =='captured' ? 'bg-primary' : 'bg-danger' }}">
            {{ $transaction->status }}
        </span>
    </td>
    <td class="text-center align-middle">
        <a class="text-primary" href="{{route('payment.invoice.download' , $transaction->id)}}">Print Invoice</a>
    </td>
</tr>
