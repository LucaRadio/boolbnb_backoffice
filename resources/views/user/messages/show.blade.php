@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <ul class="list-group mt-5">

        <li class="titolo list-group-item"> 
            <div class="d-flex justify-content-between">
                <span >
                    da {{$message->sender_name}}
                </span>

                <span>
                    {{$message->email}}
                </span>
            </div>
        </li>
        

        <li class="list-group-item">
                <p class="m-2">
                    {{$message->message}}
                </p>
        </li>
        
        </ul>

</div>

@endsection


<style scoped lang="scss">
.titolo{
    background-color: rgb(251, 226, 146) !important;
}

</style>