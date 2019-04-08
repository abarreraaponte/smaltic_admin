@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-paint-brush"></i> {{ __('Editar Artista:') . ' ' . $artist->name }}</a>
                </div>
                <div>
                    <a href="{{ '/web/artists/' . $artist->getRouteKey() }}" class="btn btn-primary"><i class="fas fa-eye"></i> {{ __('Ver Artista') }}</a>
                    <a href="/web/artists" class="btn btn-outline-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                    <a href="#" class="btn btn-outline-warning" onclick="{{ 'deactivate' . $artist->id . '()' }}"><i class="fas fa-exclamation-triangle"></i></a>
                    <a href="#" class="btn btn-outline-danger" onclick="{{ 'delete' . $artist->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $artist->getRouteKey() }}" method="post" action="{{ '/web/artists/' . $artist->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                    <form id="{{ 'deactivate-record' . $artist->getRouteKey() }}" method="post" action="{{ '/web/artists/' . $artist->getRouteKey() . '/inactivate' }}">
                        <input name="_method" type="hidden" value="PUT">
                        @csrf
                    </form>
                </div>
            </div>
            <form method="POST" action="{{ '/web/artists/' . $artist->getRouteKey() }}" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-2">{{ __('Información Principal') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="order-md-1">

                            <div id="entity_data">
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="name"><a class="text-danger">*</a> {{ __('Nombre') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="text" class="form-control" id="name" value="{{ $artist->name }}" name="name" required>
                                    </div>
                                </div>
                            </div>

                            <hr class="mb-4">

                            <button class="btn btn-primary" type="submit">{{ __('Guardar') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('ps_scripts')
    <script>
        // Warning
        $(window).on('beforeunload', function(){
            return "Any changes will be lost";
        });
        // Form Submit
        $(document).on("submit", "form", function(event){
            // disable unload warning
            $(window).off('beforeunload');
        });
    </script>
@endsection

@push('form_scripts')

    <script>
        function {{ 'delete' . $artist->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea eliminar al artista?') . ' ' . $artist->getNameValue() }}",
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

    <script>
        function {{ 'deactivate' . $artist->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea desactivar al artista?') . ' ' . $artist->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f6993f',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Desactivar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'deactivate-record' . $artist->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

@endpush