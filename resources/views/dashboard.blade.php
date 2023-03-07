@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <div class="p-3">
                    <h6>Visto che sei loggato, dai un'occhiata alla pagina dei tuoi appartamenti!</h6>
                    <button class="btn btn-primary btn-sm"><a href="{{route('user.apartments.index')}}" class="text-white">Index</a></button> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
