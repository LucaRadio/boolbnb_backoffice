@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <ul class="list-group mt-5">

        <li class="titolo list-group-item"> 
            <div class="d-flex justify-content-between">
                <span >
                    da {{$message->sender_name}}
                </span>

                <span class="darkgray d-none d-sm-block">{{$message->apartment["title"]}}</span>

                <span>
                    {{$message->email}}
                </span>
            </div>
        </li>
        

        <li class="list-group-item">
                <p class="m-2">
                    {{$message->message}}
                </p>

                <div class="d-flex justify-content-end align-items-center m-3">

                    <form action="{{ route('user.messages.delete', $message) }}" method="POST"
                        class="delete_apartment">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">Elimina messaggio</button>
                    </form>

                </div>
        </li>
        
        </ul>

</div>

@endsection


<style scoped lang="scss">
.titolo{
    background-color: rgb(251, 226, 146) !important;
}
.darkgray{
    color: darkgray;
}
</style>