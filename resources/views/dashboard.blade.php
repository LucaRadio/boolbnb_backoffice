@extends('layouts.app')
@php
    $messaggi = 0;
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 m-auto mb-5">
                <h2 class="fs-4 text-secondary my-4">
                    {{ __('Dashboard') }}
                </h2>
                <div class="card">
                    <h4 class="card-header">Bentornato {{ Auth::user()->name }}!</h4>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card p-3 mb-3">
                                    <a href="{{ route('user.messages.index') }} " class="text-decoration-none text-black">
                                        <span>Hai
                                            @foreach (Auth::user()->apartments as $apartment)
                                                @php
                                                    $messaggi = $messaggi + $apartment->messages->count();
                                                @endphp
                                            @endforeach
                                            @if ($messaggi === 1)
                                                {{ $messaggi }} messaggio
                                            @else
                                                {{ $messaggi }} messaggi
                                            @endif
                                        </span>
                                        <img src="{{ url('/1.png') }}" alt="" class="img-fluid">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card p-3 mb-3">
                                    <a href="{{ route('user.apartments.index') }}" class="text-decoration-none text-black">
                                        <span class="">I tuoi appartamenti</span>
                                        <img src="{{ url('/3.png') }}" alt="" class="img-fluid">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card  p-3 mb-3">
                                    <a href="#" class="text-decoration-none text-black">
                                        <span class="">Statistiche</span>
                                        <img src="{{ url('/2.png') }}" alt="" class="img-fluid">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card p-3 mb-3">
                                    <a href="{{ route('user.apartments.create') }}"
                                        class="text-decoration-none text-black">
                                        <span class="">Crea un appartamento</span>
                                        <img src="{{ url('/4.png') }}" alt="" class="img-fluid">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
