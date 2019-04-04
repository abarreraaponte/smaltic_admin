<table id="main_table" class="table table-sm">
    <thead class="thead-white">
    <tr>
        <th>{{ __('Fecha') }}</th>
        <th>{{ __('Clienta') }}</th>
        <th>{{ __('Artista') }}</th>
        <th>{{ __('Servicio') }}</th>
        <th>{{ __('Detalles') }}</th>
        <th>{{ __('Estado') }}</th>
        <th>{{ __('Monto') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($job_lines as $job_line)
        <tr>
            <td><a href="{{ '/web/jobs/' . $job_line->job->getRouteKey() }}" target="_blank">{{ $job_line->job->date }}</a></td>
            <td><a href="{{ '/web/customers/' . $customers->where('id', $job_line->job->customer_id)->pluck('id')->first() }}" target="_blank">{{ $customers->where('id', $job_line->job->customer_id)->pluck('name')->first() }}</a></td>
            <td><a href="{{ '/web/artists/' . $job_line->artist->getRouteKey() }}" target="_blank">{{ $job_line->artist->name }}</a></td>
            <td><a href="{{ '/web/services/' . $job_line->service->getRouteKey() }}" target="_blank">{{ $job_line->service->name }}</a></td>
            <td>{{ $job_line->job->details }}</td>
            <td>{{ $job_line->job->getPaymentStatusLabel() }}</td>
            <td>{{ $job_line->amount }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="6"><strong>Total de Venta</strong></td>
        <td><strong>{{ $amount_sum }}</strong></td>
    </tr>
    </tbody>
</table>