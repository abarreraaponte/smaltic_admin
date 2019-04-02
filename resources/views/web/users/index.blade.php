@extends('web.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                        <div>
                            <a class="h5"><i class="fas fa-users"></i> {{ __('Usuarios') }}</a>
                        </div>
                        <div>
                            <a href="/web/users/inactives/list" class="btn btn-link text-muted"><i class="fas fa-ban"></i> {{ __('View Inactive Users') }}</a>
                            <button type="button" data-toggle="modal" data-target="#adduser" href="#" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> {{ __('New User') }}</button>
                        </div>
                    </div>
                </div>
                <div class="card-body border-0">
    				<div class="table-responsive table-hover">
    			        <table id="main_table" class="table table-striped">
    			            <thead class="thead-light">
    			            <tr>
    			                <th>{{ __('Name') }}</th>
    			                <th>{{ __('Email') }}</th>
                                <th>{{ __('Role') }}</th>
    			                <th>{{ __('Actions') }}</th>
    			            </tr>
    			            </thead>
    			            <tbody>
    			            @foreach($users as $user)
    			                <tr>
    			                	<td>{{ $user->name }}</td>
    			                	<td>{{ $user->email }}</td>
                                    <td>{{ $user->getRoleLabel() }}</td>
    			                    <td>
    			                        <button type="button" data-toggle="modal" data-target="{{ '#edituser' . $user->getRouteKey() }}" class="btn btn-link" href="#"><i class="fas fa-edit"></i></button>
                                        <a class="btn btn-link" href="#" onclick='{{ 'inactivate' . $user->id . '()' }}'><i class="fas fa-exclamation-triangle" title="{{ 'Deactivate User: ' . $user->name }}"></i></a>
    			                        <a class="btn btn-link text" href="#" onclick='{{ 'delete' . $user->id . '()' }}'><i class="fas fa-trash-alt" title="{{ 'Delete User: ' . $user->name }}"></i></a>
                                        <form id="{{ 'delete-record' . $user->getRouteKey() }}" method="post" action="{{ '/web/users/' . $user->getRouteKey() }}">
                                            <input name="_method" type="hidden" value="DELETE">
                                            @csrf
                                        </form>
                                        <form id="{{ 'inactivate-record' . $user->getRouteKey() }}" method="post" action="{{ '/web/users/' . $user->getRouteKey() . '/inactivate' }}">
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

<!--Modal Addresses-->
<div class="modal fade" id="adduser" role="dialog" tabindex="-1" aria-labelledby="adduser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-lighter">
                <a class="h5 modal-title" id="contactmodallabel">{{ __('New User') }}</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/web/users">
                    @csrf
                    <label class="mt-3"><a class="text-danger">*</a> {{ __('Name') }}</label>
                    <input type="text" class="form-control" name="name" required>

                    <label class="mt-3"><a class="text-danger">*</a> {{ __('Email') }}</label>
                    <input type="email" class="form-control" name="email">

                    <label class="mt-3">{{ __('Role') }}</label>
                    <select class="form-control" name="role">
                        <option value="">Select</option>
                        @foreach($roles as $role)
                        <option value="{{ $role['name'] }}">{{ $role['label'] }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary btn-block mt-3"><i class="fas fa-plus-circle"></i> {{ __('Save User') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Individual Modals -->
@foreach($users as $user)

<!--Edit Modal-->
<div class="modal fade" id="{{ 'edituser' . $user->getRouteKey() }}" role="dialog" tabindex="-1" aria-labelledby="adduser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-lighter">
                <a class="h5 modal-title" id="contactmodallabel">Edit User: {{ $user->name }}</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/web/users/' . $user->getRouteKey() }}">
                	<input type="hidden" name="_method" value="PUT">
                    @csrf
                    <label class="mt-3"><a class="text-danger">*</a> {{ __('Name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>

                    <label class="mt-3"><a class="text-danger">*</a> {{ __('Email') }}</label>
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}">

                    <label class="mt-3">{{ __('Role') }}</label>
                    <select class="form-control" name="role">
                        <option value="">Select</option>
                        @foreach($roles as $role)
                        <option value="{{ $role['name'] }}" @if($role['name'] === $user->role) selected @endif>{{ $role['label'] }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary btn-block mt-3"><i class="fas fa-plus-circle"></i> {{ __('Update User') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach




@endsection

@section('page_scripts')
    @include('web.layouts.partials.main-datatable')
@endsection

@push('list_scripts')
    @foreach($users as $user)
        <script>
            function {{ 'delete' . $user->id . '()' }} {
                swal.fire({
                    title: "{{ 'Are you sure you wish to delete the user ' . ' ' . $user->name }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: "No, Cancel"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'delete-record' . $user->getRouteKey() }}').submit();
                        }
                    }
                )
            }
            function {{ 'inactivate' . $user->id . '()' }} {
                swal.fire({
                    title: "{{ 'Are you sure you wish to deactivate the user ' . ' ' . $user->name }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Deactivate',
                    cancelButtonText: "No, Cancel"
                }).then((result) => {
                        if (result.value) {
                            event.preventDefault();
                            document.getElementById('{{ 'inactivate-record' . $user->getRouteKey() }}').submit();
                        }
                    }
                )
            }
        </script>
    @endforeach
@endpush