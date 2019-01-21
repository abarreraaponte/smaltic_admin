@extends('web.layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-money-bill"></i> {{ __('Medios de pago Inactivos') }}</a>
	            </div>
	            <div>
	                <a href="/web/payment-methods" class="btn btn-primary"><i class="fas fa-undo"></i> {{ __('Volver')}}</a>
	            </div>
	        </div>

	        <div class="card">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-bordered table-striped">
				            <thead class="thead-light">
				            <tr>
				                <th>{{ __('Nombre') }}</th>
				                <th>{{ __('Para Ingresos') }}</th>
				                <th>{{ __('Para Egresos') }}</th>
				                <th>{{ __('Acciones') }}</th>
				            </tr>
				            </thead>
				            <tbody>
					            @foreach($payment_methods as $payment_method)
					                <tr>
					                	<td>{{ $payment_method->name }}</td>
					                	<td>
					                		@if($payment_method->for_income === 1)
					                		{{ __('Si') }}
					                		@else
					                		{{ __('No') }}
					                		@endif
					                	</td>
					                	<td>
					                		@if($payment_method->for_expense === 1)
					                		{{ __('Si') }}
					                		@else
					                		{{ __('No') }}
					                		@endif
					                	</td>
					                    <td>
					                        <a class="btn btn-sm btn-primary" href="#" onclick="{{ 'reactivate' . $payment_method->id . '()' }}"><i class="fas fa-undo"></i> {{ __('Reactivar') }}</a>
					                        <form id="{{ 'reactivate-record' . $payment_method->getRouteKey() }}" method="post" action="{{ '/web/payment-methods/' . $payment_method->getRouteKey() . '/reactivate' }}">
					                            <input name="_method" type="hidden" value="PUT">
					                            @csrf
					                        </form>
					                    </td>
					                </tr>
					            @endforeach
				            </tbody>
				        </table>
			        </div>
			    </div>
			</div>

        </div>
    </div>
</div>


@endsection

@push('list_scripts')
    @foreach($payment_methods as $payment_method)
        <script>
            function {{ 'reactivate' . $payment_method->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea reactivar el medio de pago?') . ' ' . $payment_method->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#0582ca',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Reactivar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'reactivate-record' . $payment_method->getRouteKey() }}').submit();
                        }
                    }
                )
            }
        </script>
    @endforeach
@endpush

@section('ps_scripts')
    @include('web.layouts.partials.main-datatable')
@endsection