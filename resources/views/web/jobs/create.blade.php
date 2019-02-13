@extends('web.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-calendar-check"></i> {{ __('Crear Trabajo para: ') . ' ' . $customer->name }}</a>
                </div>
                <div>
                    <a href="/web/jobs" class="btn btn-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                </div>
            </div>
            <form method="POST" action="{{ '/web/jobs/' }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-2">{{ __('Información Principal') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="order-md-1">

                            <div id="entity_data">
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="customer">{{ __('Cliente') }}</label>
                                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                        <div><a href="{{ '/web/customers/' . $customer->getRouteKey() }}" target="_blank">{{ $customer->name }}</a></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="has_reward" name="has_reward" value="1">
                                            <label class="custom-control-label" for="has_reward">{{ __('Acumula Puntos?') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="date"><a class="text-danger">*</a> {{ __('Fecha') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="details">Detalles</label>
                                        <input type="text" class="form-control" id="details" value="" name="details">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4 mb-3">
                                    <label for="service">Servicio</label>
                                    <select class="custom-select d-block w-100" id="service1" name="service_id" required>
                                        <option value="">{{ __('Seleccionar Servicio') }}</option>
                                        @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="artist">Artista</label>
                                    <select class="custom-select d-block w-100" id="artist1" name="artist_id" required>
                                        @foreach($artists as $artist)
                                        <option value="{{ $artist->id }}" @if($artist->id === $customer->artist_id) selected @endif>{{ $artist->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="amount">Monto</label>
                                    <input type="number" class="form-control" id="amount1" value="" name="amount" required>
                                </div>
                            </div>

                            <div class="row mt-4" id="secondline" style="display: none;">
                                <div class="col-md-4 mb-3">
                                    <label for="service">Servicio</label>
                                    <select class="custom-select d-block w-100" id="service2" name="service_id_2">
                                        <option value="">{{ __('Seleccionar Servicio') }}</option>
                                        @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="artist">Artista</label>
                                    <select class="custom-select d-block w-100" id="artist2" name="artist_id_2">
                                        @foreach($artists as $artist)
                                        <option value="{{ $artist->id }}" @if($artist->id === $customer->artist_id) selected @endif>{{ $artist->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="amount">Monto</label>
                                    <input type="number" class="form-control" id="amount2" value="" name="amount_2">
                                </div>
                            </div>

                            <hr class="mb-4">

                            <button class="btn btn-primary" type="submit">{{ __('Guardar') }}</button>
                            <button class="btn btn-dark" id="addsecondlinebutton" onclick="event.preventDefault(); addsecondline()">{{ __('Agregar Segunda Linea') }}</button>
                            <button class="btn btn-danger" style="display: none;" id="removesecondlinebutton" onclick="event.preventDefault(); removesecondline()">{{ __('Remover Segunda Linea') }}</button>
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
        function addsecondline() {
            document.getElementById('secondline').style.display = "";
            document.getElementById('service2').required = true;
            document.getElementById('artist2').required = true;
            document.getElementById('amount2').required = true;
            document.getElementById('addsecondlinebutton').style.display = "none";
            document.getElementById('removesecondlinebutton').style.display = "";
        };
        function removesecondline() {
            document.getElementById('secondline').style.display = "none";
            document.getElementById('service2').required = false;
            document.getElementById('artist2').required = false;
            document.getElementById('amount2').required = false;
            document.getElementById('addsecondlinebutton').style.display = "";
            document.getElementById('removesecondlinebutton').style.display = "none";
        };
    </script>
@endsection