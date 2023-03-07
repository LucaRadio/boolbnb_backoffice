@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($promotions as $promotion)
        <ul>
            <li><h6>{{$promotion->type}}</h6></li>
            <li>{{$promotion->price}}</li>
            <li>{{$promotion->duration}}</li>
        </ul>
    @endforeach
</div>
@endsection