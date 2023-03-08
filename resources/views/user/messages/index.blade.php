@extends('layouts.app')

@section('content')

<div class="container">
    
    <h1>Index messaggi</h1>
    @if (!$messages)
        <h4 class="text-warning">Non hai nuovi messaggi</h4>
    @endif
        @foreach ($messages as $item)
        @php
           $item = $item->toArray() 
        @endphp
        @if (!empty($item))
            
        <ul>
            <li><h4>Messaggio da {{$item[0]['sender_name']}}</h4></li>
            <li>Testo: {{$item[0]['message']}}</li>
        </ul>
        <button class="btn btn-primary"><a href={{route('user.messages.show', $item[0]["id"])}} class="text-decoration-none text-white">Link allo show</a></button>
        @endif
        @endforeach
</div>

@endsection