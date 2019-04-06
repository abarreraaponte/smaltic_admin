@extends('web.layouts.app')

@section('content')

@if($transfers->count() < 1)
{
	<div class="text-center mb-4">
        <img class="mb-4" src="/img/undempty05.svg" alt="" width="200">
        <h1 class="h2 mb-3 font-weight-normal">{{ __(':/ No has creado ninguna transferencia') }}</h1>
        <p>{{ __('Para crear a la primera, presiona el botón que está a continuación') }}</p>
        <a class="btn btn-lg btn-primary" href="/web/transfers/create"><i class="fas fa-exchange-alt"></i> {{ __('Crear Transferencia') }}</a>
    </div>
}

@else

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-exchange-alt"></i> {{ __('Transferencias') }}</a>
	            </div>
	            <div>
	                <a href="/web/transfers/create" class="btn btn-primary"><i class="fas fa-plus-circle"></i> {{ __('Nueva')}}</a>
	            </div>
	        </div>

	        <div class="card">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-bordered table-striped">
				            <thead class="thead-light">
				            <tr>
				                <th>{{ __('Fecha') }}</th>
	                            <th>{{ __('Cuenta Origen') }}</th>
	                            <th>{{ __('Cuenta Destino') }}</th>
								<th>{{ __('Descripción') }}</th>
								<th>{{ __('Referencia') }}</th>
								<th>{{ __('Monto') }}</th>
				                <th>{{ __('Acciones') }}</th>
				            </tr>
				            </thead>
				            <tbody>
					            @foreach($transfers as $transfer)
					                <tr>
					                	<td>{{ $transfer->date }}</td>
										<td>{{ $transfer->origin_account->name }}</td>
										<td>{{ $transfer->end_account->name }}</td>
										<td>{{ $transfer->description }}</td>
										<td>{{ $transfer->reference }}</td>
										<td>{{ $transfer->amount }}</td>
					                    <td>
					                        <a class="btn btn-sm btn-link text-danger" href="#" onclick="{{ 'delete' . $transfer->id . '()' }}"><i class="fas fa-trash-alt"></i></a>
					                        <form id="{{ 'delete-record' . $transfer->getRouteKey() }}" method="post" action="{{ '/web/transfers/' . $transfer->getRouteKey() }}">
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
    @foreach($transfers as $transfer)
        <script>
            function {{ 'delete' . $transfer->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea eliminar la transferencia?') . ' ' . $transfer->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#e84860',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Borrar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'delete-record' . $transfer->getRouteKey() }}').submit();
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