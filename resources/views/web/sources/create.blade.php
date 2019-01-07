@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-database"></i> {{ __('Crear Como nos conoce') }}</a>
                </div>
                <div>
                    <a href="/web/sources" class="btn btn-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                </div>
            </div>
            <form method="POST" action="{{ '/web/sources' }}" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control form-control-alternative" id="name" name="name" required>
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