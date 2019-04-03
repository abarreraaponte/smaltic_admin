@extends('web.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="text-center mb-4">
            <img class="mb-4" src="/img/undempty05.svg" alt="" width="400">
            <h1 class="h2 mb-3 font-weight-normal"><strong>Hola!</strong> {{ Auth::user()->name }}</h1>
            <p>{{ __('Usa la barrar superior para ir a la sección que desees') }}</p>
        </div>
    </div>
</div>
@endsection
