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

            @foreach ($messages as $message)

            <li class="list-group-item">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="m-0">{{$message['sender_name']}}</h6>

                        <span class="email">{{$message['email']}}</span>
                    </div>
                    
                    <span class="email d-none d-sm-block">{{$message->apartment["title"]}}</span>

                    <button class="btn btn-warning"><a href={{route('user.messages.show', $message["id"])}} class="text-decoration-none text-white">Leggi</a></button>
                    
                </div>
            </li>


            @endforeach
            </ul>
        @endif
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