@extends('web.layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-paint-brush"></i> {{ __('Artistas') }}</a>
	            </div>
	            <div>
	            	<a href="/web/artists/inactives/list" class="btn btn-light mr-2"><i class="fas fa-exclamation-triangle"></i> {{ __('Ver Inactivos')}}</a>
	                <a href="/web/artists/create" class="btn btn-primary"><i class="fas fa-plus-circle"></i> {{ __('Nuevo')}}</a>
	            </div>
	        </div>

	        <div class="card">
	            <div class="card-body">
					<div class="table-responsive table-hover">
				        <table id="main_table" class="table table-bordered table-striped">
				            <thead class="thead-light">
				            <tr>
				                <th>Nombre</th>
				                <th>Acciones</th>
				            </tr>
				            </thead>
				            <tbody>
					            @foreach($artists as $artist)
					                <tr>
					                	<td>{{ $artist->name }}</td>
					                    <td>
		                                    <a  class="btn btn-sm btn-primary" href="{{ '/web/artists/' . $artist->getRouteKey() }}"><i class="fas fa-eye"></i></a>
					                        <a  class="btn btn-sm btn-outline-primary" href="{{ '/web/artists/' . $artist->getRouteKey() . '/edit' }}"><i class="fas fa-edit"></i></a>
					                        <a class="btn btn-sm btn-link text-danger" href="#" onclick="{{ 'delete' . $artist->id . '()' }}"><i class="fas fa-trash-alt"></i></a>
					                        <form id="{{ 'delete-record' . $artist->getRouteKey() }}" method="post" action="{{ '/web/artists/' . $artist->getRouteKey() }}">
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
    @foreach($artists as $artist)
        <script>
            function {{ 'delete' . $artist->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea eliminar el artista?') . ' ' . $artist->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#e84860',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Borrar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'delete-record' . $artist->getRouteKey() }}').submit();
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