@extends('web.layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-chart-bar"></i> {{ __('Reportes Disponibles') }}</a>
	            </div>
	        </div>

	        <div class="card">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-bordered table-striped">
				            <thead class="thead-light">
				            <tr>
				                <th>{{ __('Nombre') }}</th>
				                <th>{{ __('Acciones') }}</th>
				            </tr>
				            </thead>
				            <tbody>
                                <tr>
                                    <td>Reporte de Clientes</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#customerreport"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
				            </tbody>
				        </table>
			        </div>
			    </div>
			</div>

        </div>
    </div>
</div>

<!--Customer Report Modal -->
<div class="modal fade" id="customerreport" role="dialog" tabindex="-1" aria-labelledby="customerreport" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="h5 modal-title" id="contactmodallabel">Agregar Filtros</a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ '/web/reports/customers' }}">
                        @csrf
                        <label class="mt-3">Solo Clientes Activos? <span class="text-muted">Opcional</span></label>
                        <br>
                        <input type="checkbox" checked name="active" value="1">

                        <br>

                        <label class="mt-3">Creado desde <span class="text-muted">Opcional</span></label>
                        <input type="date" class="form-control" name="date_created" value="{{ date('Y-m-d') }}">

                        <label class="mt-3">Artista(s)</label>
                        <select class="form-control" id="artists" name="artists[]" multiple>
                            @foreach($artists as $artist)
                                <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-dark btn-block mt-3"><i class="fas fa-search"></i> Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
