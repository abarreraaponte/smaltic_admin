@extends('web.layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-palette"></i> {{ __('Servicios Inactivas') }}</a>
	            </div>
	            <div>
	                <a href="/web/services" class="btn btn-primary"><i class="fas fa-undo"></i> {{ __('Volver')}}</a>
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
					                        <a class="btn btn-sm btn-primary" href="#" onclick="{{ 'reactivate' . $service->id . '()' }}"><i class="fas fa-undo"></i> {{ __('Reactivar') }}</a>
					                        <form id="{{ 'reactivate-record' . $service->getRouteKey() }}" method="post" action="{{ '/web/services/' . $service->getRouteKey() . '/reactivate' }}">
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
    @foreach($services as $service)
        <script>
            function {{ 'reactivate' . $service->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea reactivar el servicio?') . ' ' . $service->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#0582ca',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Reactivar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'reactivate-record' . $service->getRouteKey() }}').submit();
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