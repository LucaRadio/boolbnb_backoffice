@extends ('layouts.app')

@section('content')
    <div class="container">
        <h1>Sezione create</h1>

        <div class="text-center bg-white rounded-3 py-5" id="app">
            <form action="{{ route('user.apartments.store') }}"
                class="form-group w-75 d-inline-block shadow rounded-3 p-3 py-5" method="POST" enctype="multipart/form-data">
                @csrf()
                <div class="mb-3">
                    <label class="form-label">Nome Titolo appartemento</label>
                    <input type="text" class="form-control text-center w-75 mx-auto" name="title">
                    {{-- @error('name') is-invalid @elseif(old('name')) is-valid @enderror"
                    name="name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror --}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Numero di stanze</label>
                    <input type="number" step="1" min="0" class="form-control text-center w-75 mx-auto"
                        name="n_rooms">

                </div>
                <div class="mb-3">
                    <label class="form-label">Numero di bagni</label>
                    <input type="number" step="1" min="0" class="form-control text-center w-75 mx-auto"
                        name="n_bathrooms">

                </div>
                <div class="mb-3">
                    <label class="form-label">Numero di letti</label>
                    <input type="number" step="1" min="0" class="form-control text-center w-75 mx-auto"
                        name="n_beds">

                </div>
                <div class="mb-3">
                    <label class="form-label">Metri quadrati</label>
                    <input type="number" step="0.5" min="30" class="form-control text-center w-75 mx-auto"
                        name="square_meters">

                </div>
                <div class="mb-3">
                    <label class="form-label">Descrizione</label>
                    <textarea name="description" cols="30" rows="5" class="form-control w-75 mx-auto"></textarea>
                    {{-- @error('description') is-invalid @elseif(old('description')) is-valid @enderror">{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
                @enderror --}}
                </div>
                <div class="mb-3">
                    <label class="form-label">Indirizzo</label>
                    <input type="text" step="0.5" class="form-control text-center w-75 mx-auto" name="address"
                        v-model="searchField" @keyup="refreshSearch">

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
                                {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="serviceCheckbox_{{ $loop->index }}">{{ $service->name }}</label>
                        </div>
                    @endforeach
                    {{--     
                @error('technologys')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror --}}
                </div>
                {{-- < div class="mb-3">
            <label class="form-label">Vuoi aggiungere una promotion?</label>
            <select name="promotion_id" class="w-75 mx-auto form-select">
                <option></option>
                @foreach ($promotions as $promotion)
                <option value="{{ $promotion->id }}">{{ $promotion-> type}}</option>
                @endforeach
            </select>
    </> --}}
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
    @endsection

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
                    
                    // headers:{
                    //     "Access-Control-Allow-Origin":['*']
                    // }
                })
                    .then((resp) => {
                        this.searchData = resp.data.results;
                    })
                    .catch(err=>{console.log(err);})
            };
        }
    },
        }).mount("#app");
</script>
