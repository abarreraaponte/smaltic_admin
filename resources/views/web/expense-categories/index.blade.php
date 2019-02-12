@extends('web.layouts.app')

@section('content')

@if($expense_categories->count() < 1)
{
	<div class="text-center mb-4">
        <img class="mb-4" src="/img/undempty05.svg" alt="" width="200">
        <h1 class="h2 mb-3 font-weight-normal">{{ __(':/ No has creado ninguna categoria de gasto') }}</h1>
        <p>{{ __('Para crear la primera, presiona el botón que está a continuación') }}</p>
        <a class="btn btn-lg btn-primary" href="/web/expense-categories/create"><i class="fas fa-tags"></i> {{ __('Crear Categoria de Gasto') }}</a>
        <a class="btn btn-lg btn-link text-muted" href="/web/expense-categories/inactives/list"><i class="fas fa-exclamation-triangle"></i> {{ __('Revisar Inactivas') }}</a>
    </div>
}

@else

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-tags"></i> {{ __('Categorias de Gastos') }}</a>
	            </div>
	            <div>
	            	<a href="/web/expense-categories/inactives/list" class="btn btn-light mr-2"><i class="fas fa-exclamation-triangle"></i> {{ __('Ver Inactivos')}}</a>
	                <a href="/web/expense-categories/create" class="btn btn-primary"><i class="fas fa-plus-circle"></i> {{ __('Nuevo')}}</a>
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
		                                    <a  class="btn btn-sm btn-primary" href="{{ '/web/expense-categories/' . $expense_category->getRouteKey() }}"><i class="fas fa-eye"></i></a>
					                        <a  class="btn btn-sm btn-outline-primary" href="{{ '/web/expense-categories/' . $expense_category->getRouteKey() . '/edit' }}"><i class="fas fa-edit"></i></a>
					                        <a class="btn btn-sm btn-link text-danger" href="#" onclick="{{ 'delete' . $expense_category->id . '()' }}"><i class="fas fa-trash-alt"></i></a>
					                        <form id="{{ 'delete-record' . $expense_category->getRouteKey() }}" method="post" action="{{ '/web/expense-categories/' . $expense_category->getRouteKey() }}">
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
    @foreach($expense_categories as $expense_category)
        <script>
            function {{ 'delete' . $expense_category->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea eliminar la categoria de gasto?') . ' ' . $expense_category->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#e84860',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Borrar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'delete-record' . $expense_category->getRouteKey() }}').submit();
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