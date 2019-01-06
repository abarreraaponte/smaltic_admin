@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-user-female"></i> {{ __('Editar Clienta:') . ' ' . $customer->name }}</a>
                </div>
                <div>
                    <a href="{{ '/web/customers/' . $customer->getRouteKey() }}" class="btn btn-secondary"><i class="fas fa-eye"></i> {{ __('Ver Cliente') }}</a>
                    <a href="/web/customers" class="btn btn-light"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                    <a href="#" class="btn btn-link" onclick="{{ 'delete' . $customer->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $customer->getRouteKey() }}" method="post" action="{{ '/web/customers/' . $customer->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                </div>
            </div>
            <form method="POST" action="{{ '/web/customers/' . $customer->getRouteKey() }}" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control" id="name" value="{{ $customer->name }}" name="name" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="instagram"><i class="fab fa-instagram"></i> {{ __('Instagram') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="text" class="form-control" id="instagram" value="{{ $customer->instagram }}" name="instagram">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone"><i class="fas fa-phone"></i> {{ __('Teléfono') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="text" class="form-control" id="phone" value="{{ $customer->phone }}" name="phone" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="source">{{ __('¿Cómo nos Conoce?') }}</label>
	                                    <select class="form-control" name="source_id">
	                                        <option value="">Seleccionar</option>
	                                        @foreach($sources as $source)
	                                        <option value="{{ $source->id }}" @if($source->id === $customer->source_id) selected @endif>{{ $source->name }}</option>
	                                        @endforeach
	                                    </select>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="artist">{{ __('Artista Asignado por defecto') }}</label>
	                                    <select class="form-control" name="artist_id">
	                                        <option value="">Seleccionar</option>
	                                        @foreach($artists as $artist)
	                                        <option value="{{ $artist->id }}" @if($artist->id === $customer->artist_id) selected @endif>{{ $artist->name }}</option>
	                                        @endforeach
	                                    </select>
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
        function {{ 'delete' . $customer->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea eliminar a la clienta?') . ' ' . $customer->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#e84860',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'delete-record' . $customer->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

@endpush