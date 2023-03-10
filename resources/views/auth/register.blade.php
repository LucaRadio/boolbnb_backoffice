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
                                <div class="col-md-6 pw">
                                    <input id="password" type="password" v-model='password'
                                        v-on:focus='resetValidation("pw")'
                                        class="form-control pw @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" minlength="8"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="La password deve essere lunga almeno 8 caratteri e contenere, una lettera maiuscola, una lettera minuscola e un numero">
                                    <div class="error d-none text-danger">Le 2 password non corrispondono. Ricontrolla!
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }} (*)</label>
                                <div class="col-md-6 confPw">
                                    <input id="password-confirm" type="password" class="form-control " v-model='confPw'
                                        v-on:focus='resetValidation("confPw")' name="password_confirmation" required
                                        autocomplete="new-password" v-on:focusout='validatePassword("pw","confPw")'
                                        minlength="8">
                                    <div class="error d-none text-danger">Le 2 password non corrispondono. Ricontrolla!
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
                password:'',
                confPw:''
            }
        },
        methods: {
            validateEmail(mail) {
                    const rawDiv = document.querySelectorAll('.mail>*')
                    const input = rawDiv[0];
                    const error = rawDiv[1];

                 if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)){
                    input.classList.add('is-invalid');
                    error.classList.replace('d-none','d-block')
                   
                  }else{
                      input.classList.remove('is-invalid');
                      error.classList.replace('d-block','d-none')

                  }

                },
                resetValidation(component){
                    const rawDiv = document.querySelectorAll(`.${component}>*`)
                    const input = rawDiv[0];
                    const error = rawDiv[1];
                    if(this.mail.length){
                        input.classList.remove('is-invalid');
                        error.classList.replace('d-block','d-none')    
                    }
                    
                },
                validatePassword(pw,confPw){
                    const rawDiv1 = document.querySelectorAll(`.${confPw}>*`);
                    const input1 = rawDiv1[0];
                    const error1 = rawDiv1[1];
                    const rawDiv2 = document.querySelectorAll(`.${pw}>*`);
                    const input2 = rawDiv2[0];
                    const error2 = rawDiv2[1];
                    if(this.password != this.confPw){
                        input1.classList.add('is-invalid');
                        error1.classList.replace('d-none','d-block')
                        input2.classList.add('is-invalid');
                        error2.classList.replace('d-none','d-block')
                    }else{
                        input1.classList.remove('is-invalid');
                        error1.classList.replace('d-block','d-none')
                        input2.classList.remove('is-invalid');
                        error2.classList.replace('d-block','d-none')
                    }
                }
        },
    }).mount('#register')
</script>
