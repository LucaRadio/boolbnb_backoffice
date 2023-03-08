@extends('layouts.app')

@section('content')
@php
   $apartmentServices = $apartment->services()->get()->toArray();
   $length = sizeOf($apartmentServices)
@endphp
@if ($errors->any())
            <div class="alert alert-danger">
                I dati inseriti non sono validi:

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
<div class="container">
    <h1>Sezione edit</h1>
    <div class="text-center bg-white rounded-3 py-5">
        <form action="{{route ('user.apartments.update', $apartment->id)}}" class="form-group w-75 d-inline-block shadow rounded-3 p-3 py-5"
             method="POST" enctype="multipart/form-data">
            @csrf()
            @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nome Titolo appartemento</label>
                    <input type="text" class="form-control text-center w-75 mx-auto" name="title"
                    @error('title') is-invalid @elseif(old('title')) is-valid @enderror
                    name="title" value="{{ $apartment->title }}">
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Numero di stanze</label>
                    <input type="number" step="1" min="0" class="form-control text-center w-75 mx-auto"
                        name="n_rooms" value="{{ $apartment->n_rooms }}">

                </div>
                <div class="mb-3">
                    <label class="form-label">Numero di bagni</label>
                    <input type="number" step="1" min="0" class="form-control text-center w-75 mx-auto"
                        name="n_bathrooms" value="{{ $apartment->n_bathrooms }}">

                </div>
                <div class="mb-3">
                    <label class="form-label">Numero di letti</label>
                    <input type="number" step="1" min="0" class="form-control text-center w-75 mx-auto"
                        name="n_beds" value="{{ $apartment->n_beds }}">

                </div>
                <div class="mb-3">
                    <label class="form-label">Metri quadrati</label>
                    <input type="number" step="0.5" min="30" class="form-control text-center w-75 mx-auto"
                        name="square_meters" value="{{ $apartment->square_meters }}">

                </div>
                <div class="mb-3">
                    <label class="form-label">Descrizione</label>
                    <textarea name="description" cols="30" rows="5" class="form-control w-75 mx-auto">@error('description') is-invalid @elseif(old('description')) is-valid @enderror{{ $apartment->description }}</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
                @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Indirizzo</label>
                    <input type="text" step="0.5" class="form-control text-center w-75 mx-auto" name="address"
                        v-model="searchField" @keyup="refreshSearch" value="{{$apartment->address}}">
                    <div class="address" v-if='searchData'>
                        <ul class="list-unstyled">
                            <li v-for='item in searchData'>
                                <a href="">@{{ item.address.freeformAddress }}</a>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">Visibilità</label>
                    <label for="">No</label>
                    <input type="radio" step="0.5" class="" name="visibility" value="false">
                    <label for="">Yes</label>
                    <input type="radio" step="0.5" class="" name="visibility" value="true">

                </div>

                <div class="mb-3">
                    @foreach ($services as $service)
                        <div class="form-check form-check-inline
                  @error('services') is-invalid @enderror">
                            <input class="form-check-input @error('services') is-invalid @enderror" type="checkbox"
                                id="serviceCheckbox_{{ $loop->index }}" value="{{ $service->id }}" name="services[]"
                                 @for ($i=0; $i < $length; $i++) {{ 
                                    
                                 ($service->name === $apartment->services()->get()->toArray()[$i]['name']) ? 'checked' : '' }}@endfor>
                            <label class="form-check-label"
                                for="serviceCheckbox_{{ $loop->index }}">{{ $service->name }}</label>
                        </div>
                    @endforeach
                    <div class="mb-3">
                        <label class="form-label">Carica l'immagine del progetto</label>
                        <input type="file"
                            class="form-control text-center w-75 mx-auto
                    @error('img_cover') is-invalid @elseif(old('img_cover')) is-valid @enderror"
                            name="img_cover">
                        @error('img_cover')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button class="btn btn-lg btn-outline-dark mt-4" type="submit">Salva Progetto</button>
                </form>
            </div>
</div>
<script type="module">
    const {createApp} = Vue;
    createApp({
        data() {
            return {
                searchField: null,
                searchData: []
            }},
    methods: {
        async refreshSearch() {
            if (this.searchField) {
                encodeURIComponent(this.searchField);


                await axios.get(`https://api.tomtom.com/search/2/search/${this.searchField}.json?lat=41.9028&lon=12.4964&language=it-IT&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=all`,{
                    params:{
                        "key": 'C1SeMZqi2HmD2jfTGWrbkAAknINrhUJ3'
                    },
                    
                    
                })
                    .then((resp) => {
                        this.searchData = resp.data.results;
                    })
            };
        }
    },
        }).mount("#app");
</script>
@endsection