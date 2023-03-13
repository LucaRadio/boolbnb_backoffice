@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registrazione') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" id='register'>
                            @csrf
                            <div class="mb-4 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4 row">
                                <label for="surname"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}</label>
                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                        class="form-control @error('surname') is-invalid @enderror"
                                        value="{{ old('surname') }}">
                                </div>
                                @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4 row">
                                <label for="date_of_birth"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Data di nascita') }}</label>
                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        value="{{ old('date_of_birth') }}">
                                </div>
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4 
                                        row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}
                                    (*)</label>
                                <div class="col-md-6 mail">
                                    <input id="email" type="email" v-model='mail' v-on:focus='resetValidation("mail")'
                                        v-on:focusout='validateEmail(mail)'
                                        class="form-control @error('email') is-invalid @enderror" name="email" autofocus>
                                    <div class="error d-none text-danger">Sembra che la tua mail non abbia i requisiti per
                                        esserlo.
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4  row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}
                                    (*)</label>
                                <div class="col-md-6">

                                    <div class="input-group pw">
                                        <input id="password" type="password" v-model='pw'
                                            v-on:focus='resetValidation("pw")' v-on:focusout='validatePassword(pw)'
                                            :class='error ? "border-danger" : ""'
                                            class="form-control pw @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password" minlength="8"
                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            title="La password deve essere lunga almeno 8 caratteri e contenere, una lettera maiuscola, una lettera minuscola e un numero">
                                        <div class="input-group-appetoggle">
                                            <button @click='togglePassword("pw")'
                                                :class="error ? 'btn-danger' : 'btn-secondary'"
                                                class=" showpassword rounded-0 h-100 d-flex align-items-center rounded-end btn btn-secondary"
                                                type="button">
                                                <i v-if='show' class="fa-regular fa-eye-slash"></i>
                                                <i v-else class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="error d-none text-danger">Assicurati che la password abbia almeno una
                                            lettera maiuscola,una lettera minuscola,un carattere speciale,un numero e che
                                            sia lunga almeno 8 caratteri
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }} (*)</label>
                                <div class="col-md-6">
                                    <div class="input-group pw confpw">

                                        <input id="password-confirm" type="password" class="form-control pw"
                                            v-model='confPw' v-on:focus='resetValidation("confPw")'
                                            name="password_confirmation" required autocomplete="new-password"
                                            v-on:focusout='validateConfPassword(confPw)' minlength="8">
                                        <div class="input-group-appetoggle">
                                            <button @click='togglePassword("confPw")'
                                                :class="error ? 'btn-danger' : 'btn-secondary'"
                                                class=" showpassword rounded-0 h-100 d-flex align-items-center rounded-end btn "
                                                type="button">
                                                <i v-if='showPw' class="fa-regular fa-eye-slash"></i>
                                                <i v-else class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="error d-none text-danger">Le due password non corrispondo. Ricontrolla!
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button @click.prevent='' type="submit" class="btn btn-primary">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="container">
                            (*) = Campo obbligatorio
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script type="module">
    const {
        createApp
    } = Vue;
    createApp({
        data(){
            return{
                mail:'',
                pw:'',
                confPw:'',
                show:false,
                showPw:false,
                error: false
            }
        },
        methods: {
            validateEmail(mail) {
                    const rawDiv = document.querySelectorAll('.mail>*')
                    const input = rawDiv[0];
                    const error = rawDiv[1];



                 if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.mail)){
                    input.classList.add('is-invalid');
                    error.classList.replace('d-none','d-block')
                   
                  }else{
                      input.classList.remove('is-invalid');
                      error.classList.replace('d-block','d-none')

                  }

                },
                resetValidation(component){
                    const rawDiv = document.querySelectorAll(`.mail>*`)
                    const input = rawDiv[0];
                    const error = rawDiv[1];
                    input.classList.remove('is-invalid');
                    error.classList.replace('d-block','d-none')    
                    
                },
                validatePassword(pw){

                    const rawDiv = document.querySelectorAll(`.pw>*`)
                    // const rawDiv2 = document.querySelectorAll(`.${pw}>*`);
                    const input = rawDiv[0];
                    const button = rawDiv[1];
                    const error = rawDiv[2];
                    if(!/^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/.test(pw)){
                        input.classList.add('is-invalid');
                        error.classList.replace('d-none','d-block')
                        this.error = true
                    }else{
                        input.classList.remove('is-invalid');
                        error.classList.replace('d-block','d-none')
                        this.error = false
                    }
                },
                validateConfPassword(confPw){

                    const rawDiv = document.querySelectorAll(`.confPw>*`)
                    // const rawDiv2 = document.querySelectorAll(`.${pw}>*`);
                    const input = rawDiv[0];
                    const button = rawDiv[1];
                    const error = rawDiv[2];
                    if(this.pw !== this.confPw){
                        input.classList.add('is-invalid');
                        error.classList.replace('d-none','d-block')
                        this.error = true
                    }else{
                        input.classList.remove('is-invalid');
                        error.classList.replace('d-block','d-none')
                        this.error = false
                    }
                },
                togglePassword(component){
                    const rawDiv= document.querySelectorAll(`.${component}>*`);
                    const input = rawDiv[0]
                    const pw = component === 'pw' ? true : false;



                    if(input.type === "password" && pw){
                        input.type = "text"
                        this.show= true
                    }else if(input.type === "text" && pw){
                        input.type = "password"
                        this.show = false
                    }

                    if(input.type === "password" && !pw){
                        input.type = "text"
                        this.showPw= true
                    }else if(input.type === "text" && !pw){
                        input.type = "password"
                        this.showPw = false
                    }
                }
        },
    }).mount('#register')
</script>
