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
                <div class="hi display-2 mb-5">Registrazione</div>
                <div class="welcome fw-bold display-5 text-center">Registrati tramite il form per aggiungere e
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
            <div class="row h-100 align-content-center m-0 justify-content-center">
                <div class="col-md-8 m-0 pt-3">
                    <div class="card card-shadow border-dark m-0">
                        <div class="card-header border-dark fw-bold m-0 card-bg">{{ __('Registrazione') }}</div>
                        <div class="card-body">
                            <div class="wrapper">
                                <form method="POST" action="{{ route('register') }}" id='register'>
                                    @csrf

                                    <div class="group name">
                                        <input v-on:focus='resetValidation("name")' v-on:focusout="reset('name')"
                                            name="name" type="text" />
                                        <span class="d-block highlight"></span><span class="bar"></span>
                                        <label>Nome</label>
                                    </div>
                                    <div class="group surname">
                                        <input v-on:focus='resetValidation("surname")' v-on:focusout="reset('surname')"
                                            name="surname" type="text" />
                                        <span class="d-block highlight"></span><span class="bar"></span>
                                        <label>Cognome</label>
                                    </div>
                                    <div class="group date_of_birth">
                                        <input v-on:focus='resetValidation("date_of_birth")'
                                            v-on:focusout="reset('date_of_birth')" name="date_of_birth" type="text" />
                                        <span class="d-block highlight"></span><span class="bar"></span>
                                        <label>Data di nascita</label>
                                    </div>



                                    <div class="group mail">
                                        <input v-on:focusout='validateEmail()' v-on:focus='resetValidation("mail")'
                                            v-model='mail' name="email" v-model='mail' type="email"
                                            required="required" /><span class="d-block highlight"></span><span
                                            class="bar" name="email"></span>
                                        <label>Email *</label>
                                        <div class="error d-none text-danger">Sembra che la tua mail non abbia i
                                            requisiti
                                            per
                                            esserlo.
                                        </div>
                                    </div>



                                    <div class="group flex-column pw">
                                        <input v-model='pw' v-on:focusout='validatePassword(),validateConfPassword()'
                                            v-on:focus="resetValidation('pw')" name="password" type="password" />
                                        <span class="d-block highlight"></span><span class="bar"></span>
                                        <label>Password *</label>
                                        <div class="input-group-appetoggle eye">
                                            <button @click='togglePassword("pw")'
                                                :class="error ? 'btn-danger' : 'btn-secondary'"
                                                class=" showpassword h-100 d-flex align-items-center border-0 btn btn-secondary"
                                                type="button">
                                                <i v-if='show' class="fa-regular fa-eye-slash"></i>
                                                <i v-else class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="error d-none text-danger">Sembra che la tua password non abbia i
                                        requisiti necessari. Controlla che abbia almeno una letta maiuscola,una lettera
                                        minuscola,un numero ,e un carattere speciale.
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <div class="group flex-column confPw">
                                        <input v-model='confPw' v-on:focusout='validateConfPassword()'
                                            name="password_confirmation" v-on:focus="resetValidation('confPw')"
                                            type="password" />
                                        <span class="d-block highlight"></span><span class="bar"></span>
                                        <label>Conferma Password *</label>
                                        <div class="input-group-appetoggle eye">
                                            <button @click='togglePassword("confPw")'
                                                :class="error ? 'btn-danger' : 'btn-secondary'"
                                                class=" showpassword h-100 d-flex align-items-center border-0 btn btn-secondary"
                                                type="button">
                                                <i v-if='showPw' class="fa-regular fa-eye-slash"></i>
                                                <i v-else class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="error d-none text-danger">Le due password non corrispondono.
                                        Ricontrolla!
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror


                                    <div class="mb-4 row mb-0 mt-3 justify-content-end">
                                        <div class="col-md-6 text-end">
                                            <button :disabled='errorDigit' type="submit" class="btn btn-color btn-warning">
                                                {{ __('Registrati') }}
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="container">
                                * = Campo obbligatorio
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
                error:false,

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
            reset(component){
                const rawDiv = document.querySelectorAll(`.${component}>*`)
                const input = rawDiv[0];
                const highlight = rawDiv[1];
                const label = rawDiv[3];
                if(component === 'date_of_birth'){
                        input.type = 'text'
                    }
                if(input.value != ''){
                    label.classList.add('focused')
                }else{
                    label.classList.remove('focused')
                }

            },
            validateEmail() {
                    const rawDiv = document.querySelectorAll(`.mail>*`)
                    const input = rawDiv[0];
                    const highlight = rawDiv[1];
                    const label = rawDiv[3]
                    const error = rawDiv[4];
                 if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.mail) ){
                    this.isInvalid(input,label,highlight,error);

                   
                  }else{
                    this.isValid(input,label,highlight,error);

                  }

                },
                resetValidation(component){
                    const rawDiv = document.querySelectorAll(`.${component}>*`)
                    const input = rawDiv[0];
                    const highlight = rawDiv[1];
                    const label = rawDiv[3]
                    const error = rawDiv[4];
                    if(component === 'date_of_birth'){
                        input.type = 'date'
                    }
                    this.isValid(input,label,highlight,error);

                    
                },
                validatePassword(){
                    const rawDiv = document.querySelectorAll(`.pw>*`)
                    const input = rawDiv[0];
                    const highlight = rawDiv[1];
                    const label = rawDiv[3]
                    const error = document.querySelector(`.pw+.error`);
                    if(!/^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/.test(this.pw)){
                        this.isInvalid(input,label,highlight,error);

                    }else{
                        this.isValid(input,label,highlight,error);

                    }
                },
                validateConfPassword(){

                    const rawDiv = document.querySelectorAll(`.confPw>*`);
                    const input = rawDiv[0];
                    const highlight = rawDiv[1];
                    const label = rawDiv[3];
                    const error = document.querySelector(`.confPw+.error`);
                    console.log(error);
                    if(this.pw !== this.confPw){
                        this.isInvalid(input,label,highlight,error);

                    }else{
                        this.isValid(input,label,highlight,error);

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
                },
                isInvalid(input,label,highlight,error){
                    input?.classList.add('invalid');
                    input?.classList.add('border-0');
                    label?.classList.add('text-danger');
                    highlight?.classList.add('bg-danger,w-100');
                    highlight?.setAttribute('style','height:2px;background-color:crimson')
                    error?.classList.replace('d-none','d-block');
                    this.error = true
                    return true
                },
                isValid(input,label,highlight,error){
                    input?.classList.remove('invalid');
                    input?.classList.remove('border-0');
                    label?.classList.remove('text-danger');
                    label?.classList.add('focused');
                    highlight?.classList.remove('bg-danger,w-100');
                    highlight?.setAttribute('style','height:0px;')
                    error?.classList.replace('d-block','d-none');
                    this.error = false
                    return false
                }
        },
    }).mount('#register')
</script>
<style scoped lang='scss'>
    @media only screen and (max-width: 1200px) {
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

        .right-side {
            padding-bottom: 1rem;
        }


    }
</style>
