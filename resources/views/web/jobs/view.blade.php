@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-calendar-check"></i> {{ __('Ver Cita:') . ' ' . $job->name }}</a>
                </div>
                <div>
                    <a href="{{ '/web/jobs/' . $job->getRouteKey() . '/edit' }}" class="btn btn-primary"><i class="fas fa-edit"></i> {{ __('Editar Cita') }}</a>
                    <a href="/web/jobs" class="btn btn-outline-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                    <a href="#" class="btn btn-outline-danger" onclick="{{ 'delete' . $job->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $job->getRouteKey() }}" method="post" action="{{ '/web/jobs/' . $job->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                </div>
            </div>
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
                                        <input class="form-control" type="text" value="{{ $job->customer->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mt-6">
                                    <div class="col-md-6 mb-3">
                                        <label for="date"><a class="text-danger">*</a> {{ __('Fecha') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="text" class="form-control" id="name" value="{{ $job->date }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="hour"> {{ __('Hora') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $job->hour }}" readonly>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

@endsection

@section('ps_scripts')
    
@endsection

@push('form_scripts')

    <script>
        function {{ 'delete' . $job->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea borrar la cita?') . ' ' . $job->getNameValue() }}",
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