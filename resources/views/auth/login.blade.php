@extends('layouts.profile')
@section('styles')
@stop
@section('content')
    {{-- <link rel="stylesheet" href="C:\Users\luca1\Boolean\boolbnb_backoffice\resources\scss\profile.scss" /> --}}
    <div class="d-flex">



        <div class="left-side">
            <div class="text-black text p-5">
                <div class="hi display-1 mb-5">Login</div>
                <div class="welcome fw-bold display-4 text-center">Accedi tramite il form per visualizzare i tuoi
                    appartamenti
                </div>
            </div>
            <div class="img d-flex justify-content-center align-items-center">
            </div>
            <a class="login selected">
                Login</a>
            <a href='{{ route('register') }}' class="register ">
                Register</a>
        </div>
        <div class="right-side d-flex align-items-center" id="login">
            <div class="row m-0 row-reg justify-content-center">
                <div class="col-md-10">
                    <div class="card card-shadow border-dark">
                        <div class="card-header card-login fw-bold border-dark bg-warning">{{ __('Login') }}</div>

                        <div class="card-body position-relative">
                            <div class="wrapper">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}
                                            </div>
                                        @endforeach
                                    @endif


                                    <div class="group mail">
                                        <input @input='labelBug()' name="email" v-model='mail' type="email"
                                            required="required" /><span class="highlight"></span><span
                                            class="bar"></span>
                                        <label>Email</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="group password">
                                        <input name="password" type="password" required="required" />
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label>Password</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-4 row mb-0">
                                        <div class="col-md-8 offset-md-4 text-end">
                                            <button type="submit" class="btn btn-login btn-warning">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
        data(){
            return{
                mail:''
            }
        },
        methods: {
            labelBug(){
                const rawDiv = document.querySelectorAll('.mail>*');
                const input = rawDiv[1]
                const label = rawDiv[3]

                if(this.mail != ''){
                    label.classList.add('focused');
                    }
                    else{
                        label.classList.remove('focused');
                    }
                }
                
        },
    }).mount('#login')
</script>
