@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-exchange-alt"></i> {{ __('Crear Movimiento') }}</a>
                </div>
                <div>
                    <a href="/web/transfers" class="btn btn-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                </div>
            </div>
            <form method="POST" action="{{ '/web/transfers/' }}" enctype="multipart/form-data">
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
                                        <label for="origin_account">{{ __('Cuenta de Origen') }}</label>
                                        <select class="form-control" name="origin_account_id" id="origin_account" required>
                                            <option value="">Seleccionar</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_account">{{ __('Cuenta Destino') }}</label>
                                        <select class="form-control" name="end_account_id" id="end_account" required>
                                            <option value="">Seleccionar</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="date"><a class="text-danger">*</a> {{ __('Fecha') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="description">{{ __('Descripción') }}</label>
                                        <input type="text" class="form-control" id="description" name="description">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="reference">{{ __('Referencia') }}</label>
                                        <input type="text" class="form-control" id="reference" name="reference">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="amount"><a class="text-danger">*</a> {{ __('Monto') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="text" class="form-control" id="amount" name="amount" required>
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