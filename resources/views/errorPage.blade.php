@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row py-4">
            <div class="col col-md-6 m-auto d-flex justify-content-center">
                <div class="unauthorized_img">
                    <img src="{{ url('/no-trespassing.jpg') }}" alt="no trespassing citizen kane" class="img-fluid">
                </div>
            </div>
        </div>
        <h2 class="text-center">{{ $message }}</h2>
    </div>
@endsection
