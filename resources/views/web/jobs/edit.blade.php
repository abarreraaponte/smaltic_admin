@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-calendar-check"></i> {{ __('Editar Trabajo:') . ' ' . $job->name }}</a>
                </div>
                <div>
                    <a href="{{ '/web/jobs/' . $job->getRouteKey() }}" class="btn btn-primary"><i class="fas fa-eye"></i> {{ __('Ver Trabajo') }}</a>
                    <a href="/web/jobs" class="btn btn-outline-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                    <a href="#" class="btn btn-outline-danger" onclick="{{ 'delete' . $job->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $job->getRouteKey() }}" method="post" action="{{ '/web/jobs/' . $job->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                </div>
            </div>
            <form method="POST" action="{{ '/web/jobs/' . $job->getRouteKey() }}" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-2">{{ __('Información Principal') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="order-md-1">

                            <div id="entity_data">
                                <div class="row mt-3">
                                    <div class="col-md-3 mb-3">
                                        <label for="customer">{{ __('Cliente') }}</label>
                                        <div><a href="{{ '/web/customers/' . $job->customer->getRouteKey() }}" target="_blank">{{ $job->customer->name }}</a></div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                         <label for="amount">{{ __('Monto Total') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $job->getAmount() }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                         <label for="amount">{{ __('Monto Pagado') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $job->getPaidAmount() }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                         <label for="amount">{{ __('Monto Pendiente') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $job->getPendingAmount() }}" readonly>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="date"><a class="text-danger">*</a> {{ __('Fecha') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{ $job->date }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="details">Detalles</label>
                                        <input type="text" class="form-control" id="details" value="{{ $job->details }}" name="details">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="service">Servicio</label>
                                        <select class="custom-select d-block w-100" id="service1" name="service_id" required>
                                            <option value="">{{ __('Seleccionar Servicio') }}</option>
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}" @if($service->id === $first_line->service_id) selected @endif>{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="artist">Artista</label>
                                        <select class="custom-select d-block w-100" id="artist1" name="artist_id" required>
                                            @foreach($artists as $artist)
                                            <option value="{{ $artist->id }}" @if($artist->id === $first_line->artist_id) selected @endif>{{ $artist->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="amount">Monto</label>
                                        <input type="number" class="form-control" id="amount1" value="{{ $first_line->amount }}" name="amount" required>
                                    </div>
                                </div>
                                @if($last_line != null)
                                <div class="row mt-4" id="secondline" style="display: none;">
                                    <div class="col-md-4 mb-3">
                                        <label for="service">Servicio</label>
                                        <select class="custom-select d-block w-100" id="service2" name="service_id_2">
                                            <option value="">{{ __('Seleccionar Servicio') }}</option>
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}" @if($service->id === $last_line->service_id) selected @endif>{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="artist">Artista</label>
                                        <select class="custom-select d-block w-100" id="artist2" name="artist_id_2">
                                            @foreach($artists as $artist)
                                            <option value="{{ $artist->id }}" @if($artist->id === $last_line->artist_id) selected @endif>{{ $artist->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="amount">Monto</label>
                                        <input type="number" class="form-control" id="amount2" value="{{ $last_line->amount }}" name="amount_2">
                                    </div>
                                    <input id="toggle-delete-last-line" type="hidden" name="delete_last_line" value="0">
                                </div>
                                @else
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
                                            <option value="{{ $artist->id }}" @if($artist->id === $job->customer->artist_id) selected @endif>{{ $artist->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="amount">Monto</label>
                                        <input type="number" class="form-control" id="amount2" value="" name="amount_2">
                                    </div>
                                    <input id="toggle-delete-last-line" type="hidden" name="delete_last_line" value="0">
                                </div>
                                @endif
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
            document.getElementById('toggle-delete-last-line').value = "0";
            document.getElementById('addsecondlinebutton').style.display = "none";
            document.getElementById('removesecondlinebutton').style.display = "";
        };
        function removesecondline() {
            document.getElementById('secondline').style.display = "none";
            document.getElementById('service2').required = false;
            document.getElementById('artist2').required = false;
            document.getElementById('amount2').required = false;
            document.getElementById('toggle-delete-last-line').value = "1";
            document.getElementById('addsecondlinebutton').style.display = "";
            document.getElementById('removesecondlinebutton').style.display = "none";
        };
    </script>

    @if($last_line != null)
    <script>
        window.document.onload = addsecondline();
    </script>
    @endif

@endsection

@push('form_scripts')

    <script>
        function {{ 'delete' . $job->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea borrar el Trabajo?') . ' ' . $job->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f6993f',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'delete-record' . $job->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

@endpush