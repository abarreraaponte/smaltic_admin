@extends('web.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-warning" role="alert">
                <a class="h5">Advertencia:</a>
                <p>Esta viendo un listado de usuarios inactivos.</p>
            </div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-undo"></i> {{ __('Usuarios Inactivos') }}</a>
                </div>
                <div>
                    <a href="/web/users" class="btn btn-dark"><i class="fas fa-undo"></i> {{ __('Back to regular list') }}</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-hover">
                        <table id="main_table" class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{ __('Nombre') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="#" onclick='{{ 'reactivate' . $user->id . '()' }}'><i class="fas fa-undo"></i>{{ __('Reactivar') }}</a>
                                        <form id="{{ 'reactivate-record' . $user->getRouteKey() }}" method="post" action="{{ '/web/users/' . $user->getRouteKey() . '/reactivate' }}">
                                            <input name="_method" type="hidden" value="PUT">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ps_scripts')
    @include('web.layouts.partials.main-datatable')
@endsection

@push('list_scripts')
    @foreach($users as $user)
        <script>
            function {{ 'reactivate' . $user->id . '()' }} {
                swal.fire({
                    title: "{{ 'Are you sure you wish to reactivate the user ' . ' ' . $user->name }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Reactivate',
                    cancelButtonText: "No, Cancel"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'reactivate-record' . $user->getRouteKey() }}').submit();
                        }
                    }
                )
            }
        </script>
    @endforeach
@endpush