@extends('layouts.app')
@php
    $messaggi=0;
@endphp
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

                   <h4>Bentrornato {{ Auth::user()->name}}!</h4>
                </div>
                <div class="p-3">
                    <h6>Visto che sei loggato, dai un'occhiata alla pagina dei tuoi appartamenti!</h6>
                    <button class="btn btn-primary btn-sm mb-3"><a href="{{route('user.apartments.index')}}" class="text-white text-decoration-none">Index</a></button> 
                    <h6>Hai 
                        @foreach (Auth::user()->apartments as $apartment)
                           @php
                               $messaggi = $messaggi + $apartment->messages->count()
                           @endphp                       
                        @endforeach
                        @if ($messaggi === 1)                            
                        {{$messaggi}} messaggio
                        @else
                        {{$messaggi}} messaggi
                        @endif
                    </h6>  
                    <button class="btn btn-primary btn-sm mb-3"><a href="{{route('user.messages.index')}}" class="text-white text-decoration-none">Messaggi</a></button>
                    <h6>Dai un'occhiata alle nostre promozioni per la sponsorizzazione</h6>
                    <button class="btn btn-primary btn-sm mb-3"><a href="{{route('user.promotions.index')}}" class="text-white text-decoration-none">Promozioni</a></button>                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
