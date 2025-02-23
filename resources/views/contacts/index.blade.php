@extends('layouts.main')

@section('content')
    <style>
        .button-default {
            width: 31px !important;
            margin: 0;
            padding: 5px !important;
        }
    </style>
    <div class="dashboard-main-body">

        <x-breadcrumb route="{{ route('contact.show.all') }}" name="Contatos" subName="Listar" />

        <div class="col-xxl-12 mt-3">
            <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                <div
                    class="card-header pt-16 pb-0 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex align-items-center flex-wrap justify-content-between">
                    <h6 class="text-lg mb-0">Guias</h6>
                    <ul class="nav bordered-tab d-inline-flex nav-pills mb-0" id="pills-tab-six" role="tablist">

                        <li class="nav-item" role="presentation">
                            <a href="{{ route('contact.create') }}" class="btn btn-primary px-16 py-10 mb-3"
                                id="pills-header-nova-guia-tab">Novo Contato
                            </a>
                        </li>

                        <!-- Botão para abrir o modal de filtro -->
                        <li class="nav-item" role="presentation">
                            <button class="btn btn-info px-16 py-10 mb-3 ms-3" data-bs-toggle="modal"
                                data-bs-target="#filterModal">
                                Filtrar
                            </button>
                        </li>

                    </ul>
                </div>
                <div class="card-body p-24 pt-10">
                    <div class="tab-content" id="pills-tabContent-six">
                        <div class="tab-pane fade active show" id="pills-header-todas-guias" role="tabpanel"
                            aria-labelledby="pills-header-todas-guias-tab" tabindex="0">
                            <div>
                                <div class="col-md-12 d-flex flex-column mb-2">
                                    <label class="form-label">Localização</label>
                                    <span class="show-address"></span>
                                    <div id="map" style="height: 400px; border-radius: 10px;"></div>
                                </div>
                                <table id="contacts" class="table table-sm striped-table w-100 mt-5">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Endereço</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Filtro -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filtros de Busca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome</label>
                                <input type="text" class="filter col-md-4 form-control" id="filter-nome">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CPF</label>
                                <input type="text" class="filter col-md-4 form-control" id="filter-cpf">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bairro</label>
                                <input type="text" class="filter col-md-4 form-control" id="filter-neighborhood">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="filter col-md-4 form-control" id="filter-city">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <input type="text" class="filter col-md-4 form-control" id="filter-city">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary">Limpar</button>
                        <button type="button" class="btn btn-primary" id="applyFilters">Aplicar Filtros</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/maps.js') }}"></script>

    <script>
        function formatAddress(address) {
            // Formata o endereço de forma elegante
            let formated = address.street + ', ' + address.number;
            if (address.complement && address.complement.trim() !== '') {
                formated += ' - ' + address.complement || "";
            }

            formated +=
                `<br><small>${address.neighborhood} - ${address.city} - ${address.state} - ${address.country} | ${address.zip}</small>`;
            return formated;
        }

        let table;

        $(function() {
            const mapa = new GoogleMapHandler();
            mapa.setMapElement("map");

            const routeEdit = `{{ route('contact.edit', ['contact' => '##']) }}`;
            const routeDelete = `{{ route('contact.destroy', ['contact' => '##']) }}`;

            table = $('#contacts').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                searching: false,
                lengthChange: false,
                scrollX: true,
                language: {
                    url: "/assets/js/datatable.json"
                },
                ajax: {
                    url: @json(route('contact.index')),
                    type: "GET",
                    data: function(d) {
                        d.filter = {
                            name: $('#filter-nome').val(),
                            document: $('#filter-cpf').val(),
                            street: $('#filter-street').val(),
                            number: $('#filter-number').val(),
                            complement: $('#filter-complement').val(),
                            neighborhood: $('#filter-neighborhood').val(),
                            city: $('#filter-city').val(),
                            state: $('#filter-uf').val()
                        };
                    }
                },
                order: [
                    [0, 'asc']
                ],
                columns: [{
                        data: 'name',
                    },
                    {
                        data: 'document',
                    },
                    {
                        data: 'street',
                        render: function(data, type, row) {
                            return formatAddress(row);
                        }
                    },
                    {
                        data: 'street',
                        render: function(data, type, row) {
                            return `<div class="d-flex gap-1">
                                <a href="#" data-lat="${row.lat}" data-lng="${row.lng}" data-row='${JSON.stringify(row)}' class="show btn button-default btn-outline-info-600 btn-sm text-sm radius-8 d-flex align-items-center gap-2 button-default">
                                     <iconify-icon icon="solar:minimalistic-magnifer-zoom-in-linear" class="text-xl"></iconify-icon>
                                </a>
                                <a href="${routeEdit.replace('##', row.id)}" class="btn button-default btn-outline-primary-600 btn-sm text-sm radius-8 d-flex align-items-center gap-2 button-default">
                                     <iconify-icon icon="ic:twotone-edit-location" class="text-xl"></iconify-icon>
                                </a>
                                <a href="#" data-contact-id="${row.id}" class="destroy btn button-default btn-outline-danger-600 btn-sm text-sm radius-8 d-flex align-items-center gap-2 button-default">
                                     <iconify-icon icon="solar:trash-bin-minimalistic-outline" class="text-xl"></iconify-icon>
                                </a>
                                </div>
                            `
                        }
                    }
                ],
                drawCallback: function(settings) {
                    // Após a tabela ser desenhada, adicionar os marcadores ao mapa
                    mapa.clearMarkers();

                    // Adiciona os marcadores para os dados da página atual
                    const data = settings.json.data; // Dados da página atual

                    data.forEach(function(contact) {
                        // Verifica se as coordenadas existem antes de adicionar o marcador
                        if (contact.lat && contact.lng) {
                            mapa.addMarker(contact.lat, contact.lng);
                        }
                    });

                    mapa.fitMapToMarkers()
                }
            });

            // Evento para aplicar filtros
            $('#applyFilters').on('click', function() {
                table.draw();
                $('#filterModal').modal('hide'); // Fecha o modal após aplicar os filtros
            });


            $(document).on('click', '.destroy', function() {
                const id = $(this).data('contact-id');

                Swal.fire({
                        title: 'Atenção',
                        icon: 'question',
                        text: 'Tem certeza que deseja apagar esse usuário?',
                        showCancelButton: true,
                        cancelButtonText: 'Não',
                        confirmButtonText: 'Sim'
                    })
                    .then(r => {
                        if (r.isConfirmed) {
                            fetch(routeDelete.replace('##', id), {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content') // Adicione o CSRF token se necessário
                                    }
                                }).then(response => response
                                    .json())
                                .then(data => {
                                    if (data.status) {
                                        Swal.fire('Excluído!',
                                            'O usuário foi excluído com sucesso.', 'success');

                                        table.draw();
                                    } else {
                                        Swal.fire('Erro!',
                                            'Houve um problema ao excluir o usuário.', 'error');
                                    }
                                })
                        }
                    });
            });

            $(document).on('click', '.show', function() {
                const lat = $(this).data('lat');
                const lng = $(this).data('lng');
                const row = $(this).data('row');

                if (!row) {
                    return;
                }

                mapa.setZoomAndCenter(lat, lng, 12);

                $('.show-address').html(`
                    <div class="alert alert-primary bg-transparent text-primary-600 border-primary-600 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between mb-3 flex-wrap">
                        <div>
                            Nome: ${row.name}<br>
                            CPF: ${row.document}
                        </div>
                        <div class="text-end">${formatAddress(row)}</div>
                    </div>
                `);
            });
        });
    </script>
@endsection
