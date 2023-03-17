@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row py-5 justify-content-center">
            <div class="col-md-8">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-center align-items-center">
                        <h1 class="">{{ $apartment->title }}</h1>
                    </div>
                    <div class="d-flex gap-2">
                        <a class="btn btn-secondary" href="{{ route('user.apartments.index', $apartment) }}"><i class="fa-solid fa-house-chimney"></i></a>
                        <a class="btn btn-info" href="{{ route('user.apartments.edit', $apartment) }}"><i class="fa-solid fa-pen-fancy"></i></a>
                        <section id="buyer">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pay-promotion"><i class="fa-solid fa-rocket"></i></button>
                            <div class="modal fade" id="pay-promotion" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="delete-account" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="delete-account">Promuovi l'appartamento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h2 class="text-lg font-medium text-gray-900">
                                                {{ __('Con quale offerta vuoi promuovere il tuo appartamento?') }}
                                            </h2>
                                            <div class="row">
                                                @foreach ($promotions as $promotion)
                                                    <div class="col col-sm-6 col-md-4">
                                                        <div class="col-content">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ $promotion->type }}</h5>
                                                                    <p class="card-text">
                                                                        {{ $promotion->price }}$
                                                                        <br>
                                                                        {{ $promotion->duration }} h

                                                                    </p>
                                                                    <a class="btn btn-primary"
                                                                        href="{{ route('user.braintree', ['promotion' => $promotion, 'apartment' => $apartment]) }}">Acquista</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#delete-apartment">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <h3><span class="badge text-bg-success">{{ $apartment->address }}</span></h3>
                </div>
                <div class="mb-3">
                    <div class="py-3">
                        <img src="{{ asset('storage/' . $apartment['img_cover']) }}" alt="{{ $apartment->title }}"
                            class="img-fluid rounded-4">
                    </div>
                    <hr>
                    <div class="py-3">
                        <p class="lead">{{ $apartment->description }}</p>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Promozioni attive</h5>
                        @foreach ($apartment->promotions as $promotion_el)
                        <div class="d-flex py-2">
                            <span class="text-primary fs-2">{{$promotion_el->type}}</span>
                            <span class="px-3 d-flex align-items-center"></span>
                        </div>
                    @endforeach
                    </div>
                </div>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th>N. stanze</th>
                            <th>N. bagni</th>
                            <th>N. letti</th>
                            <th>Metri quadri</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $apartment->n_rooms }}</td>
                            <td>{{ $apartment->n_bathrooms }}</td>
                            <td>{{ $apartment->n_beds }}</td>
                            <td>{{ $apartment->square_meters }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="py-3">
                    @foreach ($apartment->services as $service)
                        <div class="d-flex py-2">
                            <span class="text-primary icon-width fs-3"><i class="{{ $service->icon }}"></i></span>
                            <span class="px-3 d-flex align-items-center">{{ $service->name }} </span>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div id="map" ref="mapRef" class="rounded-4">
                    <div id="italy"></div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="delete-apartment" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="delete-apartment" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete-apartment">Cancella appartamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 class="text-lg font-medium text-gray-900">
                        Sei sicuro di voler cancellare il tuo appartamento?
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Una volta che il tuo appartamento sarà cancellato, i dati relativi saranno cancellati
                        definitivamente ti covniene pensarci due volte!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <form action="{{ route('user.apartments.destroy', $apartment->id) }}" method="POST"
                        class="delete_apartment">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script></script>
    <script type="module">
        const {createApp,onMounted,ref} = Vue
        createApp({
            data() {
                return {
                    'apartmentList': []
                }
            },
            name: 'Map',
            mounted() {

                const sizeMapModify = document.querySelector('#italy');
                sizeMapModify.style= 'height:400px'

            },

            setup() {
                const mapRef = ref('italy');
                const id = <?php echo json_encode($apartment->id, JSON_HEX_TAG); ?>;
                

                onMounted(async () => {
                    let apartment;
                    await axios.get(`${window.location.origin}/api/apartments/${id}`)
                        .then(resp => {
                            apartment = resp.data;
                        });
                        const centerLat=apartment.latitude - 0.001
                        const centerLon=apartment.longitude - 0.001
                    const tt = window.tt;
                    var map = tt.map({
                        key: 'C1SeMZqi2HmD2jfTGWrbkAAknINrhUJ3',
                        container: mapRef.value,
                        style: 'tomtom://vector/1/basic-main/',
                        zoom: 13,
                        center: [centerLon, centerLat],
                    });
                    map.addControl(new tt.FullscreenControl());
                    map.addControl(new tt.NavigationControl());

                    addMarker(map, apartment.longitude, apartment.latitude, apartment.address);


                })

                function addMarker(map, longitude, latitude, address) {

                    const tt = window.tt;
                    var location = [longitude, latitude];
                    var popupOffset = 25;

                    var marker = new tt.Marker().setLngLat(location).addTo(map);
                    var popup = new tt.Popup({
                        offset: popupOffset
                    }).setHTML(address);
                    marker.setPopup(popup).togglePopup();

                    const mapboxglPopupContent = document.querySelector('.mapboxgl-popup-content');
                    mapboxglPopupContent.classList.add('text-black');
                }

                return {
                    mapRef,
                };
            },
        }).mount('#map')
    </script>
@endsection
