@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container py-5">

            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <div class="id">{{ $apartment->id }}</div>
                    <h2 class="mb-3">{{ $apartment->title }}</h2>
                    <h3><span class="badge text-bg-success">{{ $apartment->address }}</span></h3>
                </div>
                <div class="d-flex gap-2">
                    <a class="btn btn-info" href="{{ route('user.apartments.edit', $apartment) }}">Edit</a>
                    <section id="buyer">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pay-promotion">Promuovi l'appartamento</button>

                        <div class="modal fade" id="pay-promotion" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                                                    role="dialog" aria-labelledby="delete-account" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="delete-account">Promuovi l'appartamento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                        {{ $promotion->duration}} h

                                                    </p>
                                                    <a class="btn btn-primary" href="{{route('user.promotions.payment', $promotion->id, $apartment->id)}}" >Acquista</a>
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
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-apartment">
                        <i class="fas fa-trash"></i>
                    </button>
                    
                    
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-8">
                    <p class="lead">{{ $apartment->description }}</p>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $apartment['img_cover']) }}" alt="{{ $apartment->title }}"
                        class="img-fluid">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <h5>Promozioni attive</h5>
                    <p></p>
                </div>
                {{-- link che dovrebbe rimandare a vista front-end --}}
                <a href="#" class="btn btn-dark align-self-baseline">Vedi da ospite</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>N. stanze</th>
                        <th>N. bagni</th>
                        <th>N. letti</th>
                        <th>Metri quadri</th>
                        <th>Servizi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $apartment->n_rooms }}</td>
                        <td>{{ $apartment->n_bathrooms }}</td>
                        <td>{{ $apartment->n_beds }}</td>
                        <td>{{ $apartment->square_meters }}</td>
                        <td>
                            <ul>
                                @foreach ($apartment->services as $service)
                                    <li>{{ $service->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>


            <div id="map" ref="mapRef">
                <div id="italy"></div>
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
                        Una volta che il tuo appartamento sarà cancellato, i dati relativi saranno cancellati definitivamente ti covniene pensarci due volte!
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

    <script>
    </script>
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
