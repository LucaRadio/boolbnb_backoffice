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
        <div class="right-side d-flex align-items-center">
            <div class="row m-0 row-reg justify-content-center">
                <div class="col-md-8">
                    <div class="card border-dark">
                        <div class="card-header fw-bold border-dark bg-warning">{{ __('Login') }}</div>

                        <div class="card-body position-relative">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf


                                <div class="wrapper">
                                    <form>

                                        <div class="group">
                                            <input type="text" required="required" /><span class="highlight"></span><span
                                                class="bar"></span>
                                            <label>Email</label>
                                        </div>
                                        <div class="group">
                                            <input type="password" required="required" /><span
                                                class="highlight"></span><span class="bar"></span>
                                            <label>Password</label>
                                        </div>

                                    </form>
                                </div>

                                {{--                                 
                                <div class="mb-4 row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="mb-4 row mb-0">
                                    <div class="col-md-8 offset-md-4 text-end">
                                        <button type="submit" class="btn btn-warning">
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
@endsection
<style lang="scss">
    @import "C:\Users\luca1\Boolean\boolbnb_backoffice\resources\scss\profile.scss"
</style>
