@extends('web.layouts.app')

@section('content')

@if($payment_methods->count() < 1)
{
	<div class="text-center mb-4">
        <img class="mb-4" src="/img/undempty05.svg" alt="" width="200">
        <h1 class="h2 mb-3 font-weight-normal">{{ __(':/ No has creado ningún medio de pago') }}</h1>
        <p>{{ __('Para crear el primero, presiona el botón que está a continuación') }}</p>
        <a class="btn btn-lg btn-primary" href="/web/payment-methods/create"><i class="fas fa-money-bill"></i> {{ __('Crear Medio de Pago') }}</a>
        <a class="btn btn-lg btn-link text-muted" href="/web/payment-methods/inactives/list"><i class="fas fa-exclamation-triangle"></i> {{ __('Revisar Inactivos') }}</a>
    </div>
}

@else

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-money-bill"></i> {{ __('Medios de Pago') }}</a>
	            </div>
	            <div>
	            	<a href="/web/payment-methods/inactives/list" class="btn btn-light mr-2"><i class="fas fa-exclamation-triangle"></i> {{ __('Ver Inactivos')}}</a>
	                <a href="/web/payment-methods/create" class="btn btn-primary"><i class="fas fa-plus-circle"></i> {{ __('Nuevo')}}</a>
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
		                                    <a  class="btn btn-sm btn-primary" href="{{ '/web/payment-methods/' . $payment_method->getRouteKey() }}"><i class="fas fa-eye"></i></a>
					                        <a  class="btn btn-sm btn-outline-primary" href="{{ '/web/payment-methods/' . $payment_method->getRouteKey() . '/edit' }}"><i class="fas fa-edit"></i></a>
					                        <a class="btn btn-sm btn-link text-danger" href="#" onclick="{{ 'delete' . $payment_method->id . '()' }}"><i class="fas fa-trash-alt"></i></a>
					                        <form id="{{ 'delete-record' . $payment_method->getRouteKey() }}" method="post" action="{{ '/web/payment-methods/' . $payment_method->getRouteKey() }}">
					                            <input name="_method" type="hidden" value="DELETE">
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

@endif

@endsection

@push('list_scripts')
    @foreach($payment_methods as $payment_method)
        <script>
            function {{ 'delete' . $payment_method->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea eliminar el medio de pago?') . ' ' . $payment_method->getNameValue() }}",
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
    @endforeach
@endpush

@section('ps_scripts')
    @include('web.layouts.partials.main-datatable')
@endsection