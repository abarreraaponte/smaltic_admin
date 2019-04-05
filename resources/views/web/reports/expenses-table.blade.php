<table id="main_table" class="table table-sm">
    <thead class="thead-white">
    <tr>
        <th>{{ __('Fecha') }}</th>
        <th>{{ __('Categoria') }}</th>
        <th>{{ __('Descripcion') }}</th>
        <th>{{ __('Estado') }}</th>
        <th>{{ __('Monto') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($expense_lines as $expense_line)
        <tr>
            <td><a href="{{ '/web/expenses/' . $expense_line->expense->getRouteKey() }}" target="_blank">{{ $expense_line->expense->date }}</a></td>
            <td><a href="{{ '/web/expense-categories/' . $expense_line->expense_category->getRouteKey() }}" target="_blank">{{ $expense_line->expense_category->name }}</a></td>
            <td>{{ $expense_line->description }}</td>
            <td>{{ $expense_line->expense->getPaymentStatusLabel() }}</td>
            <td>{{ $expense_line->amount }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4"><strong>Total de Gasto</strong></td>
        <td><strong>{{ $amount_sum }}</strong></td>
    </tr>
    </tbody>
</table>