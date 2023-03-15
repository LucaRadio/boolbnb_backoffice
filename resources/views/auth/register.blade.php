@extends('layouts.profile')
@section('content')
    <div class="d-flex change">
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

        <div class="left-side">
            <div class="text-black text p-5">
                <div class="hi display-1 mb-5">Registrazione</div>
                <div class="welcome fw-bold display-4 text-center">Registrati tramite il form per aggiungere e
                    gestire i tuoi
                    appartamenti
                </div>
                .
            </div>
            <div class="img d-flex justify-content-center align-items-center">
            </div>
            <a href="{{ route('login') }}" class="login">Login</a>
            <a class="register selected">Register</a>

        </div>

        <div class="right-side">
            <div class="row align-content-center m-0 justify-content-center">
                <div class="col-md-8 m-0 pt-3">
                    <div class="card card-shadow m-0">
                        <div class="card-header fw-bold m-0 card-bg">{{ __('Registrazione') }}</div>
                        <div class="card-body">
                            <div class="wrapper">
                                <form method="POST" action="{{ route('register') }}" id='register'>
                                    @csrf
                                    {{-- <div class="mb-4 row">
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
                                    </div> --}}
                                    <div class="group mail">
                                        <input v-on:focusout='validateEmail()' v-on:focus='resetValidation("mail")'
                                            v-model='mail' @input='labelBug()' name="email" v-model='mail' type="email"
                                            required="required" /><span class="highlight"></span><span
                                            class="bar @error('email') is-invalid @enderror" name="email"></span>
                                        <label>Email</label>
                                        <div class="error d-none text-danger">Sembra che la tua mail non abbia i
                                            requisiti
                                            per
                                            esserlo.
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    {{-- <div class="mb-4 row">
                                        <label for="email"
                                            class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}
                                            (*)
                                        </label>
                                        <div class="col-md-6 mail">
                                            <input id="email" type="email" v-model='mail'
                                                v-on:focus='resetValidation("mail")' v-on:focusout='validateEmail()'
                                                class="form-control @error('email') is-invalid @enderror" name="email">
                                            <input type="hidden">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    {{-- <div class="mb-4  row">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Password') }}
                                            (*)</label>
                                        <div class="col-md-6">

                                            <div class="input-group pw">
                                                <input id="password" type="password" v-model='pw'
                                                    v-on:focus='resetValidation("pw")'
                                                    v-on:focusout='validatePassword(),validateConfPassword()'
                                                    :class='error ? "border-danger" : ""'
                                                    class="form-control pw @error('password') is-invalid @enderror"
                                                    name="password" required minlength="8"
                                                    pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}"
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
                                                <div class="error d-none text-danger">Assicurati che la password abbia
                                                    almeno
                                                    una
                                                    lettera maiuscola,una lettera minuscola,un carattere speciale,un numero
                                                    e
                                                    che
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
                                            class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }}
                                            (*)</label>
                                        <div class="col-md-6">
                                            <div class="input-group confpw pw">
                                                <input id="password-confirm" type="password" class="form-control"
                                                    v-model='confPw' name="password_confirmation" required
                                                    :class='error ? "border-danger" : ""'
                                                    v-on:focus='resetValidation("confPw")'
                                                    v-on:focusout='validateConfPassword()' minlength="8">
                                                <div class="input-group-appetoggle">
                                                    <button @click='togglePassword("confPw")'
                                                        :class="error ? 'btn-danger' : 'btn-secondary'"
                                                        class=" showpassword rounded-0 h-100 d-flex align-items-center rounded-end btn btn-secondary"
                                                        type="button">
                                                        <i v-if='showPw' class="fa-regular fa-eye-slash"></i>
                                                        <i v-else class="fa-regular fa-eye"></i>
                                                    </button>
                                                </div>
                                                <br>
                                                <div class="error d-none text-danger">Le due password non corrispondo.
                                                    Ricontrolla!
                                                </div>
                                            </div>


                                        </div>
                                    </div> --}}
                                    <div class="mb-4 row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button :disabled='errorDigit' type="submit" class="btn btn-primary">
                                                {{ __('Registrati') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="container">
                                (*) = Campo obbligatorio
                            </div>
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
        computed:{
                // errorDigit: function(){
                //     if(this.validateEmail(this.mail)){
                //         return true
                //     }else{
                //         if(this.validatePassword(this.pw)){
                //             return true
                //         }else{
                //             if(this.validateConfPassword(this.confPw)){
                //                 return true
                //             }else{
                //                 return false
                //             }
                //         }
                //     }
                            
            
                
                // }
        },
        methods: {
            validateEmail() {
                    const rawDiv = document.querySelectorAll(`.mail>*`)
                    const input = rawDiv[0];
                    const error = rawDiv[1];

                 if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.mail) ){
                    input?.classList.add('invalid');
                    error?.classList.replace('d-none','d-block');
                    return true;
                   
                  }else{
                      input?.classList.remove('invalid');
                      error?.classList.replace('d-block','d-none');
                      return false;
                  }

                },
                resetValidation(component){
                    const rawDiv = document.querySelectorAll(`.${component}>*`)
                    const input = rawDiv[0];
                    const error = rawDiv[2];
                    console.log(error);
                    input?.classList.remove('invalid');
                    error?.classList.replace('d-block','d-none')    
                    
                },
                validatePassword(){
                    const rawDiv = document.querySelectorAll(`.pw>*`)
                    const input = rawDiv[0];
                    const error = rawDiv[2];
                    if(!/^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/.test(this.pw)){
                        input?.classList.add('is-invalid');
                        error?.classList.replace('d-none','d-block')
                        this.error = true
                        return true
                    }else{
                        input?.classList.remove('is-invalid');
                        error?.classList.replace('d-block','d-none')
                        this.error = false
                        return false
                    }
                },
                validateConfPassword(){

                    const rawDiv = document.querySelectorAll(`.confPw>*`)

                    const input = rawDiv[0];
                    const error = rawDiv[2];
                    if(this.pw !== this.confPw){
                        input?.classList.add('is-invalid');
                        error?.classList.replace('d-none','d-block')
                        this.error = true
                        return true
                    }else{
                        input?.classList.remove('is-invalid');
                        error?.classList.replace('d-block','d-none')
                        this.error = false
                        return false
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
<style scoped lang='scss'>
    @media only screen and (max-width: 925px) {
        .change {
            flex-direction: column;
        }

        .register,
        .login {
            right: 0;
            padding-right: 1rem !important;
            margin-right: .65rem
        }

        .left-side {
            max-width: 100% !important
        }


    }
</style>
