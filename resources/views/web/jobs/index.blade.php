@extends('web.layouts.app')

@section('content')

@if($jobs->count() < 1)
{
	<div class="text-center mb-4">
        <img class="mb-4" src="/img/undempty05.svg" alt="" width="200">
        <h1 class="h2 mb-3 font-weight-normal">{{ __(':/ No has creado ningún Trabajo') }}</h1>
        <p>{{ __('Para crear el primero, presiona el botón que está a continuación') }}</p>
        <button data-toggle="modal" data-target="#selectcustomer" class="btn btn-lg btn-primary" href="#"><i class="fas fa-calendar-check"></i> {{ __('Crear Trabajo') }}</button>
    </div>
}

@else

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-calendar-check"></i> {{ __('Trabajos') }}</a>
	            </div>
	            <div>
	                <button data-toggle="modal" data-target="#selectcustomer" class="btn btn-primary" href="#"><i class="fas fa-calendar-check"></i> {{ __('Nuevo')}}</button>
	            </div>
	        </div>

	        <div class="card border-0 shadow-sm">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-bordered table-striped">
				            <thead class="thead-light">
				            <tr>
				                <th>{{ __('Fecha') }}</th>
				                <th>{{ __('Hora') }}</th>
				                <th>{{ __('Cliente') }}</th>
				                <th>{{ __('Acciones') }}</th>
				            </tr>
				            </thead>
				            <tbody>
					            @foreach($jobs as $job)
					                <tr>
					                	<td>{{ \Carbon\Carbon::parse($job->date)->format('d/m/Y') }}</td>
					                	<td>{{ $job->hour }}</td>
					                	<th><a href="{{ '/web/customers/' . $job->customer->getRouteKey() }}" target="_blank">{{ $job->customer->name }}</a> </th>
					                    <td>
		                                    <a  class="btn btn-sm btn-primary" href="{{ '/web/jobs/' . $job->getRouteKey() }}"><i class="fas fa-eye"></i></a>
					                        <a  class="btn btn-sm btn-outline-primary" href="{{ '/web/jobs/' . $job->getRouteKey() . '/edit' }}"><i class="fas fa-edit"></i></a>
					                        <a class="btn btn-sm btn-link text-danger" href="#" onclick="{{ 'delete' . $job->id . '()' }}"><i class="fas fa-trash-alt"></i></a>
					                        <form id="{{ 'delete-record' . $job->getRouteKey() }}" method="post" action="{{ '/web/jobs/' . $job->getRouteKey() }}">
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

<!--Modal Addresses-->
<div class="modal fade" id="selectcustomer" role="dialog" tabindex="-1" aria-labelledby="addcustomer" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a class="h5 modal-title" id="contactmodallabel">Seleccionar Cliente</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<a class="btn btn-primary mt-3 mb-3" href="/web/customers/create"><i class="fas fa-female"></i> {{ __('Nueva Clienta') }}</a>
                <div class="table-responsive table-sm table-hover">
			        <table id="secondary_table" class="table table-bordered table-striped">
			            <thead class="thead-light">
			            <tr>
			                <th>{{ __('Nombre') }}</th>
                            <th>{{ __('Instagram') }}</th>
                            <th>{{ __('Teléfono') }}</th>
			                <th>{{ __('Acciones') }}</th>
			            </tr>
			            </thead>
			            <tbody>
				            @foreach($customers as $customer)
				                <tr>
				                	<td>{{ $customer->name }}</td>
	                                <td>{{ $customer->instagram }}</td>
	                                <td>{{ $customer->phone }}</td>
				                    <td>
				                    	<a class="btn btn-sm btn-success" href="{{ '/web/customers/' . $customer->getRouteKey() . '/job/create' }}"><i class="fas fa-comment-dollar"></i> {{ __('Seleccionar') }}</a>
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

@endsection

@push('list_scripts')
    @foreach($jobs as $job)
        <script>
            function {{ 'delete' . $job->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea eliminar el Trabajo?') . ' ' . $job->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#e84860',
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
    @endforeach
@endpush

@section('ps_scripts')
    @include('web.layouts.partials.main-datatable')
    @include('web.layouts.partials.secondary-datatable')
@endsection