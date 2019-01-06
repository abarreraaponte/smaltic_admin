@extends('web.layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-female"></i> {{ __('Clientas') }}</a>
	            </div>
	            <div>
	            	<a href="/web/customers/inactives/list" class="btn btn-light mr-2"><i class="fas fa-exclamation-triangle"></i> {{ __('Ver Inactivos')}}</a>
	                <a href="/web/customers/create" class="btn btn-primary"><i class="fas fa-plus-circle"></i> {{ __('Nuevo')}}</a>
	            </div>
	        </div>

	        <div class="card">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-bordered table-striped">
				            <thead class="thead-light">
				            <tr>
				                <th>Nombre</th>
	                            <th>Instagram</th>
	                            <th>Teléfono</th>
				                <th>Acciones</th>
				            </tr>
				            </thead>
				            <tbody>
					            @foreach($customers as $customer)
					                <tr>
					                	<td>{{ $customer->name }}</td>
		                                <td>{{ $customer->instagram }}</td>
		                                <td>{{ $customer->phone }}</td>
					                    <td>
		                                    <a  class="btn btn-sm btn-primary" href="{{ '/web/customers/' . $customer->getRouteKey() }}"><i class="fas fa-eye"></i></a>
					                        <a  class="btn btn-sm btn-outline-primary" href="{{ '/web/customers/' . $customer->getRouteKey() . '/edit' }}"><i class="fas fa-edit"></i></a>
					                        <a class="btn btn-sm btn-link text-secondary" href="#" onclick="{{ 'delete' . $customer->id . '()' }}"><i class="fas fa-trash-alt"></i></a>
					                        <form id="{{ 'delete-record' . $customer->getRouteKey() }}" method="post" action="{{ '/web/customers/' . $customer->getRouteKey() }}">
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

@endsection

@push('list_scripts')
    @foreach($customers as $customer)
        <script>
            function {{ 'delete' . $customer->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea eliminar a la clienta?') . ' ' . $customer->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#e84860',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Borrar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'delete-record' . $customer->getRouteKey() }}').submit();
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