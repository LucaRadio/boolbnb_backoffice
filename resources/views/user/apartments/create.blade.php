@extends ('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center pt-5">
            <h1>Inserisci il tuo Appartamento</h1>
        </div>
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

        <div class="text-center bg-white rounded-3 py-5" id="app">
            <form action="{{ route('user.apartments.store') }}"
                class="form-group w-75 d-inline-block shadow rounded-3 p-3 py-5" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 apartmentName">
                    <label class="form-label">Titolo appartemento</label>
                    <input @input='checkData(apartmentName,"apartmentName")' v-model='apartmentName' type="text"
                        class="form-control text-center w-75 mx-auto" name="title" minlength="1" required
                        @error('title') is-invalid @elseif(old('title')) is-valid @enderror>
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="error d-none text-danger">
                        C'è qualche problema con il tuo nome. Ti consigliamo di controllare che non ci siano caratteri
                        speciali.
                    </div>

                </div>
                <div class="rooms mb-3">
                    <label class="form-label">Numero di stanze</label>
                    <input @input='checkData(rooms,"rooms")' v-model='rooms' type="number" step="1" min="0"
                        class="form-control text-center w-75 mx-auto" name="n_rooms">
                    <div class="error d-none text-danger">
                        C'è qualche problema con il numero delle stanze. Controlla che il numero sia compreso tra 1 e 255.
                    </div>

                </div>
                <div class="bath mb-3">
                    <label class="form-label">Numero di bagni</label>
                    <input @input='checkData(bath,"bath")' v-model='bath' type="number" step="1" min="0"
                        class="form-control text-center w-75 mx-auto" name="n_bathrooms">
                    <div class="error d-none text-danger">
                        C'è qualche problema con il numero dei bagni. Controlla che il numero sia compreso tra 1 e 255.
                    </div>

                </div>
                <div class="beds mb-3">
                    <label class="form-label">Numero di letti</label>
                    <input @input='checkData(beds,"beds")' v-model='beds' type="number" step="1" min="0"
                        class="form-control text-center w-75 mx-auto" name="n_beds">
                    <div class="error d-none text-danger">
                        C'è qualche problema con il numero dei letti. Controlla che il numero sia compreso tra 1 e 255.
                    </div>

                </div>
                <div class="sm mb-3">
                    <label class="form-label">Metri quadrati</label>
                    <input @input='checkData(sm,"sm")' v-model='sm' type="number" step="0.5" min="30"
                        class="form-control text-center w-75 mx-auto" name="square_meters">
                    <div class="error d-none text-danger">
                        C'è qualche problema con il numero dei metri quadrati. Controlla che il numero sia compreso tra 30 e
                        2.000.000.
                    </div>

                </div>
                <div class="mb-3">
                    <label class="form-label">Descrizione</label>
                    <textarea v-model='apartmentDescription' name="description" cols="30" rows="5"
                        class="form-control w-75 mx-auto"></textarea>
                    {{-- @error('description') is-invalid @elseif(old('description')) is-valid @enderror">{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
                @enderror --}}
                </div>
                <div class="address mb-3">
                    <label class="form-label">Indirizzo</label>
                    <input @input='checkData(searchField,"address")' type="text" step="0.5"
                        class="form-control text-center w-75 mx-auto" name="address" v-model="searchField"
                        @keyup="refreshSearch">
                    <div class="error d-none text-danger">
                        C'è qualche problema con il tuo indirizzo, assicurati che non abbia caratteri speciali e che tu
                        abbia selezionato l'indirizzo cliccandolo dal meno a tendina.
                    </div>
                    <div class="addressList" v-if='searchData'>
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
                    <input type="radio" step="0.5" name="visibility" value="false">
                    <label for="">Yes</label>
                    <input type="radio" step="0.5" name="visibility" value="true" checked>
                </div>

                <div class="services mb-3">
                    @foreach ($services as $service)
                        <div class="form-check form-check-inline
                  @error('services') is-invalid @enderror">
                            <input v-model='services' class="form-check-input @error('services') is-invalid @enderror"
                                type="checkbox" id="serviceCheckbox_{{ $loop->index }}" value="{{ $service->id }}"
                                name="services[]" {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
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
                searchField: '',
                searchData: [],
                apartmentName:'',
                rooms:'',
                bath:'',
                beds:'',
                sm:'',
                apartmentDescription:'',
                services:[],
                error:false


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
                        this.error=false
                    })
                    .catch(()=>{
                        this.error = true
                    })
            };
        },
        checkData(properties,cName){
            const specialCharacters = [
                '+',
                 '-',
                 '@',
                 '#',
                 '$',
                 '&&',
                '|',
                '=',
                 '!',
                 '%',
                 '<',
                 '>',
                 '(',
                 '`',
                 ')',
                 '{',
                 '}',
                 '[',
                 '[]',
                 ']',
                 '^',
                 '"',
                 ';',
                 '~',
                 '*',
                 '?',
                 ':'
            ]

            let className = `.${cName}>*`;

            const rawDiv = document.querySelectorAll(className)
            const input = rawDiv[1];
            const errorDiv = rawDiv[2];
            const addressList = document.querySelector('.addressList')
            if(typeof(properties) === 'number' && input.getAttribute('name') != 'square_meters'){
                if( properties <= 0 || properties >255){
                input.classList.add('is-invalid')
                errorDiv.classList.replace('d-none','d-block')
                }
                else{
                    input.classList.remove('is-invalid')
                    errorDiv.classList.replace('d-block','d-none')
                }
            }
            else if(typeof(properties) === 'number'){
                if( properties < 30 || properties >2000000){
                input.classList.add('is-invalid')
                errorDiv.classList.replace('d-none','d-block')
                }else{
                    input.classList.remove('is-invalid')
                    errorDiv.classList.replace('d-block','d-none')
                }
            }


            if(this.error && typeof(properties) === 'string'){
                input.classList.add('is-invalid')
                errorDiv.classList.replace('d-none','d-block')
                addressList.classList.add('d-none')

            }else if(typeof(properties) === 'string'){
                for(let i= 0;i<specialCharacters.length;i++){
                    if(properties.includes(specialCharacters[i])){
                        input.classList.add('is-invalid')
                        errorDiv.classList.replace('d-none','d-block')
                        addressList.classList.replace('d-block','d-none')
                        break;
                    }else{
                        input.classList.remove('is-invalid')
                        errorDiv.classList.replace('d-block','d-none')
                        addressList.classList.replace('d-none','d-block')
                        
                    }
                }
                
            }
            }
           
            
            
}
        }).mount("#app");
</script>
