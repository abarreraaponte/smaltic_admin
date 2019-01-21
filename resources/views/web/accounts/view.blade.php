@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-file-invoice-dollar"></i> {{ __('Ver Cuenta:') . ' ' . $account->name }}</a>
                </div>
                <div>
                    <a href="{{ '/web/accounts/' . $account->getRouteKey() . '/edit' }}" class="btn btn-primary"><i class="fas fa-edit"></i> {{ __('Editar Artista') }}</a>
                    <a href="/web/accounts" class="btn btn-outline-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                    <a href="#" class="btn btn-outline-warning" onclick="{{ 'deactivate' . $account->id . '()' }}"><i class="fas fa-exclamation-triangle"></i></a>
                    <a href="#" class="btn btn-outline-danger" onclick="{{ 'delete' . $account->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $account->getRouteKey() }}" method="post" action="{{ '/web/accounts/' . $account->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                    <form id="{{ 'deactivate-record' . $account->getRouteKey() }}" method="post" action="{{ '/web/accounts/' . $account->getRouteKey() . '/inactivate' }}">
                        <input name="_method" type="hidden" value="PUT">
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
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="name"><a class="text-danger">*</a> {{ __('Nombre') }}</label>
                                        <input type="text" class="form-control" id="name" value="{{ $account->name }}" readonly>
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
        function {{ 'delete' . $account->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea eliminar la cuenta?') . ' ' . $account->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#e84860',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'delete-record' . $account->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

    <script>
        function {{ 'deactivate' . $account->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea desactivar la cuenta?') . ' ' . $account->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f6993f',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'deactivate-record' . $account->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

@endpush