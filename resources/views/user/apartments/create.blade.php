@extends ('layouts.app')

@section('content')

    <div class="bg-img-form">
        <div class="container">
            <div class="row justify-content-center py-5">
                <div class="col col-md-8 p-0 g-3 my-card p-1 pb-0">

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-light rounded-5 border-0 fs-4" href="{{ route('user.dashboard') }}"><i class="fa-solid fa-x"></i></a>
                    </div>

                    <div class="text-center py-4">
                        <h1>Crea Appartamento</h1>
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

                    <div class="pb-2" id="app">
                        <form action="{{ route('user.apartments.store') }}" class="form-group d-inline-block" method="POST"
                            enctype="multipart/form-data" id="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 apartmentName">
                                        <label class="form-label">Titolo appartemento *</label>
                                        <input @input='checkData(apartmentName,"apartmentName")' v-model='apartmentName'
                                            type="text" class="form-control mx-auto rounded-5" name="title"
                                            minlength="1" required
                                            @error('title') is-invalid @elseif(old('title')) is-valid @enderror>
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="error d-none text-danger">
                                            C'è qualche problema con il tuo nome. Ti consigliamo di controllare che non ci
                                            siano
                                            caratteri
                                            speciali.
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="rooms mb-3 col-sm-6">
                                            <label class="form-label">Numero di stanze *</label>
                                            <input @input='checkData(rooms,"rooms")' v-model='rooms' type="number"
                                                step="1" min="0" class="form-control mx-auto rounded-5"
                                                name="n_rooms">
                                            <div class="error d-none text-danger">
                                                C'è qualche problema con il numero delle stanze. Controlla che il numero sia
                                                compreso
                                                tra 1
                                                e
                                                255.
                                            </div>

                                        </div>

                                        <div class="bath mb-3 col-sm-6">
                                            <label class="form-label">Numero di bagni *</label>
                                            <input @input='checkData(bath,"bath")' v-model='bath' type="number"
                                                step="1" min="0" class="form-control mx-auto rounded-5"
                                                name="n_bathrooms">
                                            <div class="error d-none text-danger">
                                                C'è qualche problema con il numero dei bagni. Controlla che il numero sia
                                                compreso
                                                tra 1
                                                e
                                                255.
                                            </div>

                                        </div>

                                        <div class="beds mb-3 col-sm-6">
                                            <label class="form-label">Numero di letti *</label>
                                            <input @input='checkData(beds,"beds")' v-model='beds' type="number"
                                                step="1" min="0" class="form-control mx-auto rounded-5"
                                                name="n_beds">
                                            <div class="error d-none text-danger">
                                                C'è qualche problema con il numero dei letti. Controlla che il numero sia
                                                compreso
                                                tra 1
                                                e
                                                255.
                                            </div>

                                        </div>

                                        <div class="sm mb-3 col-sm-6">
                                            <label class="form-label">Metri quadrati *</label>
                                            <input @input='checkData(sm,"sm")' v-model='sm' type="number" step="0.5"
                                                min="30" class="form-control mx-auto rounded-5" name="square_meters">
                                            <div class="error d-none text-danger">
                                                C'è qualche problema con il numero dei metri quadrati. Controlla che il
                                                numero
                                                sia
                                                compreso
                                                tra
                                                30 e
                                                2.000.000.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="apartmentDescription mb-3">
                                        <label class="form-label">Descrizione</label>
                                        <textarea v-model='apartmentDescription' name="description" cols="30" rows="5"
                                            class="form-control mx-auto rounded-5"></textarea>
                                    </div>

                                    <div class="address mb-3">
                                        <label class="form-label">Indirizzo *</label>
                                        <input @input='checkData(searchField,"address")' type="text" step="0.5"
                                            autocomplete="off" class="form-control mx-auto rounded-5" name="address"
                                            v-model="searchField" @keyup="refreshSearch">
                                        <div class="error d-none text-danger">
                                            C'è qualche problema con il tuo indirizzo, assicurati che non abbia caratteri
                                            speciali e
                                            che
                                            tu
                                            abbia selezionato l'indirizzo cliccandolo dal menù a tendina.
                                        </div>
                                        <div class="list-group addressList">
                                            <a :value='i' v-for='(item,i) in searchData'
                                                class="list-group-item list-group-item-action" @click='choosenAddress(i)'>
                                                @{{ item.address.freeformAddress }}
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="img_cover mb-3">
                                        <label class="form-label">Carica l'immagine del progetto *</label>
                                        <input @change='imgCoverChange' type="file"
                                            class="rounded-5 form-control  mx-auto
                                @error('img_cover') is-invalid @elseif(old('img_cover')) is-valid @enderror"
                                            name="img_cover">
                                        @error('img_cover')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="visibility mb-3 form-check form-switch">
                                        <label class="form-label px-2">Visibilità *</label>
                                        <br>
                                        <label class="px-2 form-check-label" for="">Non Visibile</label>
                                        <input class="px-2 form-check-input" type="radio" step="0.5"
                                            name="visibility" value="false">
                                        <br>
                                        <label class="px-2 form-check-label" for="">Visibile</label>
                                        <input class="px-2 form-check-input" type="radio" step="0.5"
                                            name="visibility" value="true" checked>
                                    </div>

                                    <div class="services mb-3 row px-3">
                                        <div class="rules p-0">Servizi *</div>
                                        @foreach ($services as $service)
                                            <div class="col-sm-6 col-md-6 px-0 d-flex justify-content-start">
                                                <div class="m-0 form-check form-switch @error('services') is-invalid @enderror d-flex justify-content-center align-items-center">
                                                    <input v-model='services'
                                                        class="form-check-input @error('services') is-invalid @enderror"
                                                        type="checkbox" id="serviceCheckbox_{{ $loop->index }}"
                                                        value="{{ $service->id }}" name="services[]"
                                                        {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label text-start"
                                                        for="serviceCheckbox_{{ $loop->index }}">
                                                        <div class="d-flex justify-content-center align-items-center ">
                                                            <div class="icon-width">
                                                                <i class="{{ $service->icon }} text-primary px-3"></i>
                                                            </div>
                                                            <div class="">{{ $service->name }}</div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                </div>
                            </div>
                            <div class="text-center">
                                <button :disabled='errorDigit' class="btn btn-lg btn-outline-light mt-1 rounded-5"
                                    type="submit">Salva
                                    Appartamento</button>
                                    <button class="btn btn-lg btn-outline-light mt-1 rounded-5 mx-3"
                                    type="reset">Svuota Campi</button>
                            </div>
                        </form>
                        <div class="container text-start text-small">
                            * Campi Obbligatori
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                img_cover:'',
                error:false


            }},
            computed:{
                errorDigit: function (){
                    if(this.apartmentName.length <=0 || this.apartmentName.length>255){
                        return true
                        }else {
                            if(this.rooms <0 || this.rooms>255){
                                return true
                            }else {
                                if(this.bath <=0 || this.bath>255){
                                    return true
                            }else {
                                if(this.beds <=0 || this.beds>255){
                                    return true
                            }else {
                                if(this.sm <30 || this.sm>2000000){
                                    return true
                            }else {
                                if(this.searchField <=0 || this.searchField>255){
                                    return true
                            }else {
                                if(!this.services.length){
                                    return true
                            }else {
                                if(!this.img_cover){
                                    return true
                            }else{
                                    return false
                                    }
                                }
                            }
                            }}}}};

                    } 
            },
            methods: {
                imgCoverChange(event){
                    const chosenFiles = event.target.files
                    this.img_cover = chosenFiles[0];

                },
                choosenAddress(i){
                    const rawDiv = document.querySelector('.addressList')
                    const tagA = document.querySelectorAll('.addressList > a');
                    this.searchField = tagA[i].textContent;
                    rawDiv.classList.add('d-none')

                    
                },
                

        

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
                    console.log(input.classList);
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
                if(properties === 'addressList' ){
                    addressList.classList.replace('d-block','d-none');
                }
                input.classList.add('is-invalid')
                errorDiv.classList.replace('d-none','d-block')
            }else if(!this.error && typeof(properties) === 'string'){
                if(!properties === 'addressList'){
                    addressList.classList.replace('d-none','d-block')
                }
                input.classList.remove('is-invalid')
                errorDiv.classList.replace('d-block','d-none') 
            }
                     
            }
            
           
            
            
}
        }).mount("#form");
</script>
