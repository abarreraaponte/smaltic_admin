@extends('web.layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-credit-card"></i> {{ __('Gasto') }}</a>
	            </div>
	            <div>
	                <a class="btn btn-primary" href="/web/expenses/create"><i class="fas fa-credit-card"></i> {{ __('Nuevo')}}</a>
	            </div>
	        </div>

	        <div class="card">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-bordered table-striped">
				            <thead class="thead-light">
				            <tr>
				                <th>{{ __('Fecha') }}</th>
				                <th>{{ __('Categoria') }}</th>
				                <th>{{ __('Descripcion') }}</th>
								<th>{{ __('Estado de Pago') }}</th>
				                <th>{{ __('Monto') }}</th>
				                <th>{{ __('Acciones') }}</th>
				            </tr>
				            </thead>
				            <tbody>
					            @foreach($expense_lines as $expense_line)
					                <tr>
					                	<td>{{ $expense_line->expense->date }}</td>
					                	<td>{{ $expense_line->expense_Category->name }}</td>
					                	<td>{{ $expense_line->description }}</td>
										<td><span class="badge badge-dark ml-2">{{ $expense_line->expense->getPaymentStatusLabel() }}</span></td>
					                	<td>{{ $expense_line->amount }}</td>
					                    <td>
		                                    <a  class="btn btn-sm btn-primary" href="{{ '/web/expenses/' . $expense_line->expense->getRouteKey() }}"><i class="fas fa-eye"></i></a>
					                        <a  class="btn btn-sm btn-outline-primary" href="{{ '/web/expenses/' . $expense_line->expense->getRouteKey() . '/edit' }}"><i class="fas fa-edit"></i></a>
					                        <a class="btn btn-sm btn-link text-danger" href="#" onclick="{{ 'delete' . $expense_line->id . '()' }}"><i class="fas fa-trash-alt"></i></a>
					                        <form id="{{ 'delete-record' . $expense_line->expense->getRouteKey() }}" method="post" action="{{ '/web/expenses/' . $expense_line->expense->getRouteKey() }}">
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
    @foreach($expense_lines as $expense_line)
        <script>
            function {{ 'delete' . $expense_line->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea eliminar el Trabajo?') . ' ' . $expense_line->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#e84860',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Borrar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'delete-record' . $expense_line->expense->getRouteKey() }}').submit();
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
