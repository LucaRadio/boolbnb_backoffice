@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sezione Index</h1>
        <div class="row">
            @foreach ($apartments as $item)
                <div class="col col-sm-6 col-md-3 g-4">
                    <div class="">
                        <div class="card" style="width: 18rem;">
                            @if (str_contains($item->img_cover, 'https://picsum.photos'))
                                <img class="card-img-top" src=" {{ $item['img_cover'] }}" alt="Card image cap">
                            @else
                                <img class="card-img-top" src="{{ asset('storage/' . $item['img_cover']) }}"
                                    alt="Card image cap">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->title }}</h5>
                                <p class="card-text">{{ $item->description }}</p>
                                <a href={{ route('user.apartments.show', $item->id) }} class="btn btn-primary">Vedi Dettagli Appartamento</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
