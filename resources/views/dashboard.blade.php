@extends('layouts.app')
@php
    $messaggi = 0;
@endphp
@section('content')
    <div class="container dashboard_container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10 m-auto mb-5">
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

                        <div class="row gap-3 gap-lg-0">
                            <div class="col-lg-4">
                                <div class="row flex-column gap-3">
                                    <div class="col">
                                        <a href="{{ route('user.messages.index') }} "
                                            class="text-decoration-none text-black">
                                            <div class="card p-3">
                                                <div class="card_title">
                                                    <h5>Hai
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
                                                    </h5>
                                                </div>
                                                <div class="card_img d-flex justify-content-center">
                                                    <img src="{{ url('/1.png') }}" alt="" class="w-50 img-fluid">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="#" class="text-decoration-none text-black">
                                            <div class="card  p-3">
                                                <div class="card_title">
                                                    <h5 class="">Statistiche</h5>
                                                </div>
                                                <div class="card_img d-flex justify-content-center">
                                                    <img src="{{ url('/2.png') }}" alt="" class="w-50 img-fluid">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <a href="{{ route('user.apartments.index') }}" class="text-decoration-none text-black">
                                    <div class="card p-3 h-100  d-flex justify-content-between">
                                        <div class="card_title">
                                            <h5 class="">I tuoi appartamenti</h5>
                                        </div>
                                        <div class="card_img">
                                            <img src="{{ url('/3.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="{{ route('user.apartments.create') }}" class="text-decoration-none text-black">
                                    <div class="card p-3 h-100 d-flex justify-content-between">
                                        <div class="card_title">
                                            <h5 class="">Crea un appartamento</h5>
                                        </div>
                                        <div class="card_img">
                                            <img src="{{ url('/4.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
