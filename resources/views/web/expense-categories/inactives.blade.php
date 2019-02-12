@extends('web.layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-tags"></i> {{ __('Categorias de Gasto Inactivas') }}</a>
	            </div>
	            <div>
	                <a href="/web/expense-categories" class="btn btn-primary"><i class="fas fa-undo"></i> {{ __('Volver')}}</a>
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
					            @foreach($expense_categories as $expense_category)
					                <tr>
					                	<td>{{ $expense_category->name }}</td>
					                    <td>
					                        <a class="btn btn-sm btn-primary" href="#" onclick="{{ 'reactivate' . $expense_category->id . '()' }}"><i class="fas fa-undo"></i> {{ __('Reactivar') }}</a>
					                        <form id="{{ 'reactivate-record' . $expense_category->getRouteKey() }}" method="post" action="{{ '/web/expense-categories/' . $expense_category->getRouteKey() . '/reactivate' }}">
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
    @foreach($expense_categories as $expense_category)
        <script>
            function {{ 'reactivate' . $expense_category->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea reactivar la categoria de gasto?') . ' ' . $expense_category->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#0582ca',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Reactivar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'reactivate-record' . $expense_category->getRouteKey() }}').submit();
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