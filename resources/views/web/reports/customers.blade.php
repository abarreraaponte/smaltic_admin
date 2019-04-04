@extends('web.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-users"></i> {{ __('Reporte de Clientes') }}</a>
	            </div>
	        </div>

	        <div class="card shadow-sm border-0">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-sm">
				            <thead class="thead-white">
				            <tr>
				                <th>{{ __('Nombre') }}</th>
				            </tr>
				            </thead>
				            <tbody>
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
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
