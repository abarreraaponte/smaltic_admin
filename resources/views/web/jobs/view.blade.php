@extends('web.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-calendar-check"></i> {{ __('Ver Trabajo de:') . ' ' . $job->customer->name }} <span class="badge badge-dark ml-2">{{ $job->getPaymentStatusLabel() }}</span></a>
                </div>
                <div>
                    <a href="{{ '/web/jobs/' . $job->getRouteKey() . '/edit' }}" class="btn btn-primary"><i class="fas fa-edit"></i> {{ __('Editar Trabajo') }}</a>
                    <a href="/web/jobs" class="btn btn-outline-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                     @if($job->payment_status != 'paid')
                    <button type="button" data-toggle="modal" data-target="#addpayment"  class="btn btn-success"><i class="fas fa-dollar-sign"></i> {{ __('Registrar Pago') }}</button>
                    @if($points >= config('app.reward_baseline'))
                        <button type="button" data-toggle="modal" data-target="#usereward"  class="btn btn-warning"><i class="fas fa-award"></i> {{ __('Usar Puntos') }}</button>
                    @endif
                    @endif
                    <a href="#" class="btn btn-outline-danger" onclick="{{ 'delete' . $job->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $job->getRouteKey() }}" method="post" action="{{ '/web/jobs/' . $job->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                </div>
            </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-header border-0">
                        <h4 class="mt-2">{{ __('Información Principal') }}</h4>
                    </div>
                    <div class="card-body">
                        @if($available_discount_amount > 0 and $job->payment_status != 'paid')
                            <div class="alert alert-secondary" role="alert">
                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap">
                                    <a>{{ 'Este cliente tiene' . ' ' . $available_discount_amount . ' ' . 'pesos disponibles para. descuentos.' }}</a>
                                    <button class="btn btn-sm btn-secondary" type="button" data-toggle="modal" data-target="#applydiscount">{{ 'Aplicar Descuentos' }}</button>
                                </div>
                            </div>
                        @endif
                        <div class="order-md-1">
                            <div id="entity_data">
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="customer">{{ __('Cliente') }}</label>
                                        <div><a href="{{ '/web/customers/' . $job->customer->getRouteKey() }}" target="_blank">{{ $job->customer->name }}</a></div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="customer">{{ __('Puntos Disponibles') }}</label>
                                        <div>{{ $points }}</div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                         <label for="amount">{{ __('Monto Total') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $job->getAmount() }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                         <label for="amount">{{ __('Monto Pagado') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $job->getPaidAmount() }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                         <label for="amount">{{ __('Monto Pendiente') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $job->getPendingAmount() }}" readonly>
                                    </div>
                                </div>
                                <div class="row mt-6">
                                    <div class="col-md-6 mb-3">
                                        <label for="date"><a class="text-danger">*</a> {{ __('Fecha') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="text" class="form-control" id="name" value="{{ $job->date }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="hour"> {{ __('Detalles') }}</label>
                                        <input type="text" class="form-control" id="details" value="{{ $job->details }}" readonly>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="service">Servicio</label>
                                        <input type="text" class="form-control" id="service_1" value="{{ $first_line->service->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="artist">Artista</label>
                                        <input type="text" class="form-control" id="artist_1" value="{{ $first_line->artist->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="amount">Monto</label>
                                        <input type="number" class="form-control" id="amount_1" value="{{ $first_line->amount }}" readonly>
                                    </div>
                                </div>
                                @if($last_line != null)
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="service">Servicio</label>
                                        <input type="text" class="form-control" id="service_2" value="{{ $last_line->service->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="artist">Artista</label>
                                        <input type="text" class="form-control" id="artist_2" value="{{ $last_line->artist->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="amount">Monto</label>
                                        <input type="number" class="form-control" id="amount_2" value="{{ $last_line->amount }}" readonly>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    @include('web.jobs.payments')

    @include('web.jobs.discount-modal')

</div>

@endsection

@section('ps_scripts')

@endsection

@push('form_scripts')

    <script>
        function {{ 'delete' . $job->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea borrar el Trabajo?') . ' ' . $job->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f6993f',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'delete-record' . $job->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

    @foreach($payments as $payment)
        <script>
            function {{ 'deletepayment' . $payment->id . '()' }} {
                    swal({
                        title: "Estás seguro que deseas este pago?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Borrar',
                        cancelButtonText: "No, Cancelar"
                    }).then((result) => {
                            if (result.value) {
                                event.preventDefault();
                                document.getElementById('{{ 'delete-payment' . $payment->getRouteKey() }}').submit();
                            }
                        }
                    )
                }
        </script>
    @endforeach

@endpush
