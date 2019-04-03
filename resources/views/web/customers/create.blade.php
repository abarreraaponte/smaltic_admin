@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-female"></i> {{ __('Crear Clienta') }}</a>
                </div>
                <div>
                    <a href="/web/customers" class="btn btn-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                </div>
            </div>
            <form method="POST" action="{{ '/web/customers/' }}" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="instagram"><i class="fab fa-instagram"></i> {{ __('Instagram') }}</label>
                                        <input type="text" class="form-control" id="instagram" name="instagram" placeholder="{{ __('@smaltic_art') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone"><i class="fas fa-phone"></i> {{ __('Teléfono') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="56912345678" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="source">{{ __('¿Cómo nos Conoce?') }}</label>
	                                    <select class="form-control" name="source_id" onchange="toggleReferrer()" id="source">
	                                        <option value="">Seleccionar</option>
	                                        @foreach($sources as $source)
	                                        <option value="{{ $source->id }}">{{ $source->name }}</option>
	                                        @endforeach
	                                    </select>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="artist">{{ __('Artista Asignado por defecto') }}</label>
	                                    <select class="form-control" name="artist_id">
	                                        <option value="">Seleccionar</option>
	                                        @foreach($artists as $artist)
	                                        <option value="{{ $artist->id }}">{{ $artist->name }}</option>
	                                        @endforeach
	                                    </select>
                                    </div>
                                </div>
                                <div id="referrer" class="row mt-3" style="display: none;">
                                    <div class="col-md-6 mb-3">
                                        <label for="source">{{ __('Referente') }}</label>
                                        <select class="form-control" name="referrer_id" id="referrer_id">
                                            <option value="">Seleccionar</option>
                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
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
    <script>
        function toggleReferrer() {

            var reference_source = "{{ $reference_source }}";

            if(document.getElementById('source').value === reference_source)
            {
                document.getElementById('referrer').style.display = "";
                document.getElementById('referrer_id').required = true;
            }

            else
            {
                document.getElementById('referrer').style.display = "none";
                document.getElementById('referrer_id').required = false;
            }


        }
    </script>
@endsection