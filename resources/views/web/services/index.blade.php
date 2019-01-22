@extends('web.layouts.app')

@section('content')

@if($services->count() < 1)
{
	<div class="text-center mb-4">
        <img class="mb-4" src="/img/undempty05.svg" alt="" width="200">
        <h1 class="h2 mb-3 font-weight-normal">{{ __(':/ No has creado ningún servicio') }}</h1>
        <p>{{ __('Para crear el primero, presiona el botón que está a continuación') }}</p>
        <a class="btn btn-lg btn-primary" href="/web/services/create"><i class="fas fa-palette"></i> {{ __('Crear Servicio') }}</a>
        <a class="btn btn-lg btn-link text-muted" href="/web/services/inactives/list"><i class="fas fa-exclamation-triangle"></i> {{ __('Revisar Inactivos') }}</a>
    </div>
}

@else

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-palette"></i> {{ __('Servicios') }}</a>
	            </div>
	            <div>
	            	<a href="/web/services/inactives/list" class="btn btn-light mr-2"><i class="fas fa-exclamation-triangle"></i> {{ __('Ver Inactivos')}}</a>
	                <a href="/web/services/create" class="btn btn-primary"><i class="fas fa-plus-circle"></i> {{ __('Nuevo')}}</a>
	            </div>
	        </div>

	        <div class="card">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-bordered table-striped">
				            <thead class="thead-light">
				            <tr>
				                <th>{{ __('Nombre') }}</th>
				                <th>{{ __('Precio Base') }}</th>
				                <th>{{ __('Acciones') }}</th>
				            </tr>
				            </thead>
				            <tbody>
					            @foreach($services as $service)
					                <tr>
					                	<td>{{ $service->name }}</td>
					                	<td>{{ $service->price }}</td>
					                    <td>
		                                    <a  class="btn btn-sm btn-primary" href="{{ '/web/services/' . $service->getRouteKey() }}"><i class="fas fa-eye"></i></a>
					                        <a  class="btn btn-sm btn-outline-primary" href="{{ '/web/services/' . $service->getRouteKey() . '/edit' }}"><i class="fas fa-edit"></i></a>
					                        <a class="btn btn-sm btn-link text-danger" href="#" onclick="{{ 'delete' . $service->id . '()' }}"><i class="fas fa-trash-alt"></i></a>
					                        <form id="{{ 'delete-record' . $service->getRouteKey() }}" method="post" action="{{ '/web/services/' . $service->getRouteKey() }}">
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
    @foreach($services as $service)
        <script>
            function {{ 'delete' . $service->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea eliminar el servicio?') . ' ' . $service->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#e84860',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Borrar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'delete-record' . $service->getRouteKey() }}').submit();
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