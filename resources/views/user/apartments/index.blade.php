@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sezione Index</h1>

        @foreach ($apartments as $item)
            @dump($item)
        @endforeach
    </div>
@endsection
