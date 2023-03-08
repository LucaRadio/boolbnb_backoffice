@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sezione Index</h1>
        <div class="row">
            @foreach ($apartments as $item)

                <div class="col col-sm-6 col-md-4">
                    <div class="col-content">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src={{ 'public/storage/cover_img/NoImageFound.jpg.png' }} alt="Card image cap">
                            <div class="card-body">
                              <h5 class="card-title">{{$item->title}}</h5>
                              <p class="card-text">{{$item->description}}</p>
                              <a href={{ route('user.apartments.show', $item->id) }} class="btn btn-primary">vai allo Show</a>
                            </div>
                          </div>
                    </div>
                </div>
            @endforeach
        </div>
</div>
@endsection
