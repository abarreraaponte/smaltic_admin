<table id="main_table" class="table table-sm">
    <thead class="thead-white">
    <tr>
        <th>{{ __('Fecha') }}</th>
        <th>{{ __('Descripcion') }}</th>
        <th>{{ __('Referencia') }}</th>
        <th>{{ __('Monto') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->date }}</td>
            <td>
                @if($payment->customer != null)
                    {{ 'Pago por trabajo de:' . ' ' . $payment->customer->name }}
                @elseif($payment->expense != null)
                    {{ 'Gasto' . ' ' . $payment->expense->expense_lines->pluck('description')->first() }}
                @elseif($payment->job === null and $payment->expense === null)
                    {{ 'Transferencia' }}
                @endif
            </td>
            <td>{{ $payment->reference }}</td>
            <td>{{ $payment->amount }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td><strong>{{ $amount_sum }}</strong></td>
    </tr>
    </tbody>
</table>