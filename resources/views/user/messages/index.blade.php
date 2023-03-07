@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Index messaggi</h1>
    @foreach ($messages as $item)
            @dump($item)
        @endforeach
</div>

@endsection