<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale('')) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Axios --}}

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">

        <div class="whole-page-overlay d-block" id="whole_page_loader">
            <div class="img-container w-100 h-100">
                <div class="cover"></div>
                <img class="center-loader w-100 h-100 img-fluid"
                    src="https://cdn.dribbble.com/users/729829/screenshots/3499449/media/fb22fc6c15045b2a7e5bb6329965e574.gif" />
            </div>
        </div>

        <main class="">
            @yield('content')
        </main>
    </div>

</body>

</html>

<style lang="scss">
    .whole-page-overlay {
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        position: fixed;
        width: 100%;
        height: 100% !important;
        z-index: 1050;
        background-color: #efefef;


    }

    .img-container {
        display: flex;
        justify-content: center;
        align-items: stretch;
        position: relative;
    }

    .cover {
        align-self: end;
        height: 20%;
        position: absolute;
        background: #efefef;
        right: 0px;
        width: 100%;
    }


    @media only screen and (max-width: 576px) {
        .cover {
            height: 30%;
        }

    }
</style>
