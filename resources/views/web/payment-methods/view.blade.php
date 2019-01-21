@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-money-bill"></i> {{ __('Ver Medio de Pago:') . ' ' . $payment_method->name }}</a>
                </div>
                <div>
                    <a href="{{ '/web/payment-methods/' . $payment_method->getRouteKey() . '/edit' }}" class="btn btn-primary"><i class="fas fa-edit"></i> {{ __('Editar Artista') }}</a>
                    <a href="/web/payment-methods" class="btn btn-outline-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                    <a href="#" class="btn btn-outline-warning" onclick="{{ 'deactivate' . $payment_method->id . '()' }}"><i class="fas fa-exclamation-triangle"></i></a>
                    <a href="#" class="btn btn-outline-danger" onclick="{{ 'delete' . $payment_method->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $payment_method->getRouteKey() }}" method="post" action="{{ '/web/payment-methods/' . $payment_method->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                    <form id="{{ 'deactivate-record' . $payment_method->getRouteKey() }}" method="post" action="{{ '/web/payment-methods/' . $payment_method->getRouteKey() . '/inactivate' }}">
                        <input name="_method" type="hidden" value="PUT">
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
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="name"><a class="text-danger">*</a> {{ __('Nombre') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $payment_method->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3 my-auto">
                                        <div class="ml-auto">
                                            <div class="custom-control custom-checkbox mr-sm-2 mt-3">
                                                <input type="checkbox" class="custom-control-input" @if($payment_method->for_income === 1) checked @endif id="for_income" disabled>
                                                <label class="custom-control-label" for="for_income">{{ __('Para Ingresos') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3 my-auto">
                                        <div class="ml-auto">
                                            <div class="custom-control custom-checkbox mr-sm-2 mt-3">
                                                <input type="checkbox" class="custom-control-input" @if($payment_method->for_expense === 1) checked @endif id="for_expense" disabled>
                                                <label class="custom-control-label" for="for_expense">{{ __('Para Egresos') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

@endsection

@section('ps_scripts')
    
@endsection

@push('form_scripts')

    <script>
        function {{ 'delete' . $payment_method->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea eliminar la cuenta?') . ' ' . $payment_method->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#e84860',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'delete-record' . $payment_method->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

    <script>
        function {{ 'deactivate' . $payment_method->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea desactivar la cuenta?') . ' ' . $payment_method->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f6993f',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'deactivate-record' . $payment_method->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

@endpush