@extends('web.layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
	    <div class="col col-md-12">
	         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
	            <div>
	                <a class="h5"><i class="fas fa-paint-brush"></i> {{ __('Artistas Inactivos') }}</a>
	            </div>
	            <div>
	                <a href="/web/artists" class="btn btn-primary"><i class="fas fa-undo"></i> {{ __('Volver')}}</a>
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
					            @foreach($artists as $artist)
					                <tr>
					                	<td>{{ $artist->name }}</td>
					                    <td>
					                        <a class="btn btn-sm btn-primary" href="#" onclick="{{ 'reactivate' . $artist->id . '()' }}"><i class="fas fa-undo"></i> {{ __('Reactivar') }}</a>
					                        <form id="{{ 'reactivate-record' . $artist->getRouteKey() }}" method="post" action="{{ '/web/artists/' . $artist->getRouteKey() . '/reactivate' }}">
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
    @foreach($artists as $artist)
        <script>
            function {{ 'reactivate' . $artist->id . '()' }} {
                swal({
                    title: "{{ __('Seguro que desea reactivar al artista?') . ' ' . $artist->getNameValue() }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#0582ca',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Reactivar',
                    cancelButtonText: "No, Cancelar"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'reactivate-record' . $artist->getRouteKey() }}').submit();
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