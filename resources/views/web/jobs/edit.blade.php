@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-calendar-check"></i> {{ __('Editar Cita:') . ' ' . $job->name }}</a>
                </div>
                <div>
                    <a href="{{ '/web/jobs/' . $job->getRouteKey() }}" class="btn btn-primary"><i class="fas fa-eye"></i> {{ __('Ver Cita') }}</a>
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
                                    <div class="col-md-6 mb-3">
                                        <label for="customer">{{ __('Cliente') }}</label>
                                        <select class="form-control" name="customer_id" required>
                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" @if($customer->id === $job->customer_id) selected @endif>{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="date"><a class="text-danger">*</a> {{ __('Fecha') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{ $job->date }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="hour"> {{ __('Hora') }}</label>
                                        <input type="time" class="form-control" id="hour" name="hour" value="{{ $job->hour }}">
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
        function {{ 'deactivate' . $job->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea desactivar la cita?') . ' ' . $job->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f6993f',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'deactivate-record' . $job->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

@endpush