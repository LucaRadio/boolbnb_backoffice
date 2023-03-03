@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sezione create</h1>

        <div class="text-center bg-white rounded-3 py-5">
        <form action="{{route ('user.apartments.store')}}" class="form-group w-75 d-inline-block shadow rounded-3 p-3 py-5"
         method="POST" enctype="multipart/form-data">
            @csrf()
            
            <button class="btn btn-lg btn-outline-dark mt-4" type="submit">Salva Progetto</button>
        </form>
    </div>
    </div>
@endsection