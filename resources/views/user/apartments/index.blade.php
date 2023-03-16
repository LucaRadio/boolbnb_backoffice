@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center pt-5 m-0 pb-3">
            <h1 class="m-0">I Tuoi Appartamenti</h1>
        </div>

        <div class="row g-3">
            @foreach ($apartments as $item)
                <div class="col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center">
                    <div class="card">
                        @if (str_contains($item->img_cover, 'https://picsum.photos'))
                            <img class="card-img-top" src=" {{ $item['img_cover'] }}" alt="Card image cap">
                        @else
                            <img class="card-img-top" src="{{ asset('storage/' . $item['img_cover']) }}"
                                alt="Card image cap">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ $item->description }}</p>
                            <a href={{ route('user.apartments.show', $item->id) }} class="btn btn-primary">Vedi Dettagli
                                Appartamento</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
