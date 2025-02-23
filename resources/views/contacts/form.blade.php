@extends('layouts.main')

@section('content')
    <div class="dashboard-main-body">
        <x-breadcrumb route="{{ route('contact.show.all') }}" name="Contatos" subName="{{ isset($contact) ? 'Editar' : 'Adicionar' }}" />

        <div class="col-xxl-12">
            <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                <div
                    class="card-header pt-16 pb-16 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex align-items-center flex-wrap justify-content-between">
                    <h6 class="text-lg mb-0">{{ isset($contact) ? 'Editar Contato' : 'Novo Contato' }}</h6>
                </div>
                <div class="card-body p-24 pt-10">
                    <form method="POST" action="{{ isset($contact) ? route('contact.update', $contact->id) : route('contact.store') }}" class="row gy-3 needs-validation" novalidate>
                        @csrf
                        @if(isset($contact)) @method('PUT') @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" placeholder="Digite o nome"
                                value="{{ old('name', $contact->name ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">CPF</label>
                            <input type="text" name="document" id="document" class="form-control"
                                placeholder="Digite o documento" value="{{ old('document', $contact->document ?? '') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">CEP</label>
                            <input type="text" name="zip" id="zip" class="form-control"
                                value="{{ old('zip', $contact->zip ?? '') }}" placeholder="Digite o CEP" required>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Logradouro</label>
                            <input type="text" name="street" id="street" class="form-control"
                                value="{{ old('street', $contact->street ?? '') }}" placeholder="Logradouro" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Número</label>
                            <input type="text" name="number" id="number" class="form-control" placeholder="Número"
                                value="{{ old('number', $contact->number ?? '') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Complemento</label>
                            <input type="text" name="complement" id="complement" class="form-control"
                                value="{{ old('complement', $contact->complement ?? '') }}" placeholder="Complemento">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Bairro</label>
                            <input type="text" name="neighborhood" id="neighborhood" class="form-control"
                                value="{{ old('neighborhood', $contact->neighborhood ?? '') }}" placeholder="Bairro" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cidade</label>
                            <input type="text" name="city" id="city" class="form-control" placeholder="Cidade"
                                value="{{ old('city', $contact->city ?? '') }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">UF</label>
                            <input class="form-control" id="state" name="state" value="{{ old('state', $contact->state ?? '') }}" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">País</label>
                            <input class="form-control" id="country" name="country" value="{{ old('country', $contact->country ?? '') }}" />
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Localização</label>
                            <div id="map" style="height: 400px; border-radius: 10px;"></div>
                        </div>

                        <input type="hidden" name="lat" id="lat" value="{{ old('lat', $contact->lat ?? '') }}" />
                        <input type="hidden" name="lng" id="lng" value="{{ old('lng', $contact->lng ?? '') }}" />

                        <div class="col-md-12">
                            <button class="btn btn-primary-600" type="submit">{{ isset($contact) ? 'Atualizar' : 'Salvar' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/maps.js') }}"></script>

    <script>
        const cepRoute = '{{ route('cep', ['cep' => '##']) }}';
        const mapa = new GoogleMapHandler();

        function loadCep() {
            let cep = $('#zip').val().replace(/\D/g, '');
            if (cep.length === 8) {
                // $("#street, #neighborhood, #city, #state").val("Carregando...");

                $.getJSON(cepRoute.replace('##', cep), function(data) {
                    if (!("erro" in data)) {
                        $("#street").val(data.logradouro);
                        $("#neighborhood").val(data.bairro);
                        $("#city").val(data.localidade);
                        $("#state").val(data.uf);
                        $("#country").val('Brazil');

                       

                        // Gera endereço completo para buscar coordenadas
                        let fullAddress =
                            `${data.logradouro}, ${data.localidade}, ${data.uf}, Brasil`;

                        let lat = data.coordinates.lat;
                        let lng = data.coordinates.lng;

                        $("#lat").val(lat);
                        $("#lng").val(lng);

                        mapa.clearMarkers();
                        mapa.addMarker(lat, lng, $('#name').val());
                        mapa.setZoomAndCenter(lat, lng, 12);
                    } else {
                        $("#street, #neighborhood, #city, #state").val("");
                    }
                });
            }
        }

        $(document).ready(function() {
            mapa.setMapElement("map");
            mapa.autoComplete('street', (place) => {
                const lat = place.geometry.location.lat();
                const lng = place.geometry.location.lng();

                $("#lat").val(lat);
                $("#lng").val(lng);

                $("#street").val(mapa.getAddressComponent("route"));
                $("#number").val(mapa.getAddressComponent("street_number"));
                $("#neighborhood").val(mapa.getAddressComponent("sublocality_level_1") || mapa.getAddressComponent("political"));
                $("#city").val(mapa.getAddressComponent("administrative_area_level_2"));
                $("#state").val(mapa.getAddressComponent("administrative_area_level_1", true));
                $("#zip").val(mapa.getAddressComponent("postal_code"));
                $("#country").val(mapa.getAddressComponent("country"));

                mapa.clearMarkers();
                mapa.addMarker(lat, lng, place.formatted_address);
                mapa.setZoomAndCenter(lat, lng, 12);
            });

            $('#zip').mask('99999-999');
            $('#document').mask('999.999.999-99');

            // Busca endereço pelo CEP
            $('#zip').on('blur', function() {
                loadCep();
            });
        });
    </script>
@endsection
