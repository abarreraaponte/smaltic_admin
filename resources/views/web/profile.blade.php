@extends('web.layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-2">
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				<a class="nav-link active" id="profile-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="profile" aria-selected="true">{{ __('Perfil') }}</a>
				{{-- <a class="nav-link" id="apikey-tab" data-toggle="pill" href="#apikey" role="tab" aria-controls="apikey" aria-selected="false">{{ __('API') }}</a> --}}
			</div>
		</div>
		<div class="col-10">
			<div class="tab-content" id="v-pills-tabContent">
				<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="card border-0 shadow-sm">
						<div class="card-header border-0">
							<h5>{{ __('Informacion de Perfil') }}</h5>
						</div>
						<div class="card-body border-0">
							<form method="POST" action="{{ '/web/profile/' }}" enctype="multipart/form-data" autocomplete="off">
								<input type="hidden" name="_method" value="PUT">
								@csrf
								<div class="form-group row">
									<label for="inputName3" class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputName3" placeholder="name" name="name" value="{{ Auth::user()->name }}" autocomplete="off" data-lpignore=true>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
									<div class="col-sm-10">
										<input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email" value="{{ Auth::user()->email }}" autocomplete="off" data-lpignore=true>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputPassword3" name="password" placeholder="Enter new password (Optional)" autocomplete="off" data-lpignore=true>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-10">
										<button type="submit" class="btn btn-primary">{{ __('Actualizar Perfil') }}</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				{{-- <div class="tab-pane fade" id="apikey" role="tabpanel" aria-labelledby="apikey-tab">
					<passport-personal-access-tokens></passport-personal-access-tokens>
				</div> --}}
			</div>
		</div>
	</div>
</div>
@endsection

@push('form_scripts')
    <script>
        if(window.location.hash)
        {
            const anchor = window.location.hash;
            $(`a[href="${anchor}"]`).tab('show')
        }
    </script>
@endpush
