<section>
    <header>
        <h2 class="text-secondary">
            {{ __('Informazioni del profilo') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __('In questo sito non puoi cambiare i tuoi dati personali. Puoi cambiare solo email e password.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-2 d-flex">
            <div class="fw-bold text-primary">Nome:&nbsp;</div>
            @if ($user->name)
                <p class="m-0">{{ $user->name }}</p>
            @else
                <p class="m-0">Nessun nome inserito</p>
            @endif

        </div>

        <div class="mb-2 d-flex">
            <div class="fw-bold text-primary">Cognome:&nbsp;</div>
            @if ($user->surname)
                <p class="m-0">{{ $user->surname }}</p>
            @else
                <p class="m-0">Nessun cognome inserito</p>
            @endif

        </div>

        <div class="mb-2 d-flex">
            <div class="fw-bold text-primary">Data di nascita:&nbsp;</div>
            @if ($user->date_of_birth)
                <p class="m-0">{{ date('d-M-Y', strtotime($user->date_of_birth)) }}</p>
            @else
                <p class="m-0">Nessuna data di nascita inserito</p>
            @endif

        </div>

        <div class="mb-2">
            <label for="email">
                {{ __('Email') }}
            </label>

            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />

            @error('email')
                <span class="alert alert-danger mt-2" role="alert">
                    <strong>{{ $errors->get('email') }}</strong>
                </span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-muted">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-outline-dark">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-4">
            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <script>
                    const show = true;
                    setTimeout(() => show = false, 2000)
                    const el = document.getElementById('profile-status')
                    if (show) {
                        el.style.display = 'block';
                    }
                </script>
                <p id='profile-status' class="fs-5 m-0 text-success"><i
                        class="fa-solid text-success me-2 fa-circle-check"></i>Operazione effettuata.</p>
            @endif
        </div>
    </form>
</section>
