@extends('web.layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col col-md-12">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                    <div>
                        <a class="h5"><i class="fas fa-calendar-check"></i> {{ __('Reporte de Cuenta:' . ' ' . $account->name . ' ' . 'Desde:' . ' ' . $date_from . ' ' . 'Hasta:' . ' ' . $date_until ) }}</a>
                    </div>
                    <a class="btn btn-dark" href="/web/reports"><i class="fas fa-list"></i> Volver</a>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive table-hover">
                            @include('web.reports.accounts-table')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
