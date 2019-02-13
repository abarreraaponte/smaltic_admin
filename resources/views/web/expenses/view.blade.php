@extends('web.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-credit-card"></i> {{ __('Ver Gasto') }}</a>
                </div>
                <div>
                    <a href="{{ '/web/expenses/' . $expense->getRouteKey() . '/edit' }}" class="btn btn-primary"><i class="fas fa-edit"></i> {{ __('Editar Gasto') }}</a>
                    <a href="/web/expenses" class="btn btn-outline-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                    <button type="button" data-toggle="modal" data-target="#addpayment"  class="btn btn-success"><i class="fas fa-dollar-sign"></i> {{ __('Registrar Pago') }}</button>
                    <a href="#" class="btn btn-outline-danger" onclick="{{ 'delete' . $expense->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $expense->getRouteKey() }}" method="post" action="{{ '/web/expenses/' . $expense->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                </div>
            </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-2">{{ __('Información Principal') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="order-md-1">

                            <div id="entity_data">
                                <div class="row mt-3">
                                    <div class="col-md-4 mb-3">
                                         <label for="amount">{{ __('Monto Total') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $expense->getAmount() }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                         <label for="amount">{{ __('Monto Pagado') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $expense->getPaidAmount() }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                         <label for="amount">{{ __('Monto Pendiente') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $expense->getPendingAmount() }}" readonly>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="date"><a class="text-danger">*</a> {{ __('Fecha') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="date" class="form-control" id="date" value="{{ $expense->date }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="details">{{ __('Descripción') }}</label>
                                        <input type="text" class="form-control" id="description" value="{{ $expense_line->description }}" readonly>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="service">Categoria</label>
                                        <input type="text" class="form-control" id="expene_cateogory_id" value="{{ $expense_line->expense_category->name }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="amount">Monto</label>
                                        <input type="number" class="form-control" id="amount1" value="{{ $expense_line->amount }}" readonly>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
        </div>
    </div>

    @include('web.expenses.payments')
    
</div>

@endsection

@section('ps_scripts')
    
@endsection

@push('form_scripts')

    <script>
        function {{ 'delete' . $expense->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea borrar el Gasto?') . ' ' . $expense->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f6993f',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'delete-record' . $expense->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

    @foreach($expense_payments as $expense_payment)
        <script>
            function {{ 'deletepayment' . $expense_payment->id . '()' }} {
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
                                document.getElementById('{{ 'delete-payment' . $expense_payment->getRouteKey() }}').submit();
                            }
                        }
                    )
                }
        </script>
    @endforeach

@endpush