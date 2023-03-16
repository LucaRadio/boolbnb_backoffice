@extends('layouts.app')

@section('content')

<div class="container mt-4">
    
    <h1>I tuoi messaggi</h1>

    @if (!$messages)
        <h4 class="text-warning">Non hai nuovi messaggi</h4>
    @endif

    <div class="pt-4">
        @if ($messages)
        <ul class="list-group">
        
        
        <li class="titolo list-group-item"> 
            Titolo
        </li>
        @foreach ($messages as $item)
        @php
           $item = $item->toArray() 
        @endphp
        

        <li class="list-group-item">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="m-0">{{$item[0]['sender_name']}}</h6>

                    <span class="email">{{$item[0]['email']}}</span>
                </div>

                <button class="btn btn-warning"><a href={{route('user.messages.show', $item[0]["id"])}} class="text-decoration-none text-white">Leggi</a></button>
            </div>
        </li>
        
        
        @endforeach
        @endif
        </ul>
    </div>
    
        
</div>

@endsection

<style scoped lang="scss">
.titolo{
    background-color: rgb(251, 226, 146) !important;
}

.email{
    color: darkgray;
}
</style>