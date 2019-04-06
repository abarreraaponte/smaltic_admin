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
                                    <td>Reporte de Ventas</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-dark" href="#" data-toggle="modal" data-target="#salesreport"><i class="fas fa-search"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reporte de Gastos</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-dark" href="#" data-toggle="modal" data-target="#expensesreport"><i class="fas fa-search"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reporte de Cuentas</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-dark" href="#" data-toggle="modal" data-target="#accountsreport"><i class="fas fa-search"></i></button>
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

<!--Sales Report Modal -->
<div class="modal fade" id="salesreport" role="dialog" tabindex="-1" aria-labelledby="salesreport" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <a class="h5 modal-title" id="contactmodallabel">Filtros - Reporte de Ventas</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/web/reports/sales' }}">
                    @csrf

                    <label class="mt-3">Fecha Desde <span class="text-muted">Opcional</span></label>
                    <input type="date" class="form-control" name="date_from" value="{{ date('Y-m-d') }}">

                    <label class="mt-3">Fecha Hasta<span class="text-muted">Opcional</span></label>
                    <input type="date" class="form-control" name="date_until" value="{{ date('Y-m-d') }}">

                    <label class="mt-3">Artista(s)</label>
                    <select class="form-control" id="artists" name="artists[]" multiple>
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                        @endforeach
                    </select>

                    <label class="mt-3">Servicio(s)</label>
                    <select class="form-control" id="services" name="services[]" multiple>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>

                    <label class="mt-3">Estado de Pago</label>
                    <select class="form-control" id="payment_statuses" name="payment_statuses[]" multiple>
                        @foreach($payment_statuses as $payment_status)
                            <option value="{{ $payment_status['name'] }}">{{ $payment_status['label'] }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-success btn-block mt-3"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Expenses Report Modal -->
<div class="modal fade" id="expensesreport" role="dialog" tabindex="-1" aria-labelledby="expensesreport" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <a class="h5 modal-title" id="contactmodallabel">Filtros - Reporte de Gastos</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/web/reports/expenses' }}">
                    @csrf

                    <label class="mt-3">Fecha Desde <span class="text-muted">Opcional</span></label>
                    <input type="date" class="form-control" name="date_from" value="{{ date('Y-m-d') }}">

                    <label class="mt-3">Fecha Hasta<span class="text-muted">Opcional</span></label>
                    <input type="date" class="form-control" name="date_until" value="{{ date('Y-m-d') }}">

                    <label class="mt-3">Categoria(s)</label>
                    <select class="form-control" id="categories" name="categories[]" multiple>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <label class="mt-3">Estado de Pago</label>
                    <select class="form-control" id="payment_statuses" name="payment_statuses[]" multiple>
                        @foreach($payment_statuses as $payment_status)
                            <option value="{{ $payment_status['name'] }}">{{ $payment_status['label'] }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-danger btn-block mt-3"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Accounts Report Modal -->
<div class="modal fade" id="accountsreport" role="dialog" tabindex="-1" aria-labelledby="accountsreport" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <a class="h5 modal-title" id="contactmodallabel">Filtros - Reporte de Cuentas</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/web/reports/accounts' }}">
                    @csrf

                    <label class="mt-3">Fecha Desde <span class="text-muted">Opcional</span></label>
                    <input type="date" class="form-control" name="date_from" value="{{ date('Y-m-d') }}">

                    <label class="mt-3">Fecha Hasta<span class="text-muted">Opcional</span></label>
                    <input type="date" class="form-control" name="date_until" value="{{ date('Y-m-d') }}">

                    <label class="mt-3">Cuenta a Consultar</label>
                    <select class="form-control" id="account" name="account_id" required>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-info btn-block mt-3"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
