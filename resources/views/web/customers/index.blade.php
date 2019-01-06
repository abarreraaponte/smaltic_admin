@extends('web.layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-users"></i> {{ __('Clientes') }}</a>
	            </div>
	            <div>
	                <button type="button" data-toggle="modal" data-target="#addcustomer" href="#" class="btn btn-primary"><i class="fas fa-plus-circle"></i> {{ __('Nuevo')}}</button>
	            </div>
	        </div>

	        <div class="card">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-sm table-bordered table-striped">
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
		                                    <a  class="btn btn-sm btn-info" href="{{ '/web/customers/' . $customer->getRouteKey() }}"><i class="fas fa-eye"></i></a>
					                        <a  class="btn btn-sm btn-dark" href="{{ '/web/customers/' . $customer->getRouteKey() . '/edit' }}"><i class="fas fa-edit"></i></a>
					                        <a class="btn btn-sm btn-danger" href="#" onclick="event.preventDefault();
					                                document.getElementById('{{ 'delete-record' . $customer->getRouteKey() }}').submit();"><i class="fas fa-trash-alt"></i></a>
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