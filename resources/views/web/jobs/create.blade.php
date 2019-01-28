@extends('web.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-calendar-check"></i> {{ __('Crear Trabajo') }}</a>
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
                                        <select class="form-control" name="customer_id" required>
                                            <option value="">Seleccionar</option>
                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="date"><a class="text-danger">*</a> {{ __('Fecha') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="hour"> {{ __('Hora') }}</label>
                                        <input type="time" class="form-control" id="hour" name="hour">
                                    </div>
                                </div>
                            </div>

                            <hr class="mb-4">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-4">
                                <div>
                                    <a class="h5"><i class="fas fa-calendar-plus"></i> {{ __('Detalles del Trabajo') }}</a>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-sm btn-secondary" onclick="addline()"><i class="fas fa-plus"></i> {{ __('Agregar Línea') }}</a>
                                </div>
                            </div>
                            <div id="lines">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="service">Servicio</label>
                                        <select class="custom-select d-block w-100" id="service_id" name="service_id[]" required>
                                            <option value="">{{ __('Seleccionar Servicio') }}</option>
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="artist">Artista</label>
                                        <select class="custom-select d-block w-100" id="artist_id" name="artist_id[]" required>
                                            <option value="">{{ __('Seleccionar Artista') }}</option>
                                            @foreach($artists as $artist)
                                            <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="details">Detalles</label>
                                        <input type="text" class="form-control" id="details" value="" name="details[]">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="amount">Monto</label>
                                        <input type="number" class="form-control" id="amount" value="" name="amount[]" required>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label>-</label>
                                        <div>
                                            <a class="btn btn-link" onclick="deleteline(this)"><i class="text-danger fas fa-times"></i></a>
                                        </div>
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
        function addline() {
            var lines = document.getElementById("lines");
            var clone = lines.lastElementChild.cloneNode(true);
            lines.appendChild(clone);
        }
        function deleteline(line)
        {
            line.closest(".row").remove();
        }
    </script>
@endsection