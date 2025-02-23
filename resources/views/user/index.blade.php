@extends('layouts.main')

@section('content')
    <div class="dashboard-main-body">
        <x-breadcrumb route="#" name="Usuário" subName="Editar" />

        <div class="col-xxl-12">
            <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                <div
                    class="card-header pt-16 pb-0 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex align-items-center flex-wrap justify-content-between">
                    <h6 class="text-lg mb-0">Meus Dados</h6>
                    <ul class="nav bordered-tab d-inline-flex nav-pills mb-0" id="pills-tab-six" role="tablist">


                        <!-- Botão para abrir o modal de filtro -->
                        <li class="nav-item" role="presentation">
                            <button class="btn btn-danger px-16 py-10 mb-3 ms-3 cancel-account"
                                data-bs-target="#filterModal">
                                Cancelar Conta
                            </button>
                        </li>

                    </ul>
                </div>

                <div class="card-body p-24 pt-10">
                    <form method="POST" action="{{ route('user.update') }}" class="row gy-3 needs-validation">
                        @csrf
                        @method('PUT')

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
                                value="{{ old('name', $user->name ?? '') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ old('email', $user->email ?? '') }}" required>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary-600" type="submit">{{ 'Atualizar' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).on('click', '.cancel-account', function() {
            const id = $(this).data('contact-id');
            const routeDelete = ``.replace('##', id);

            Swal.fire({
                title: 'Confirmação de Senha',
                text: 'Por favor, insira sua senha para confirmar a exclusão do usuário.',
                input: 'password', // Tipo de input será senha
                inputPlaceholder: 'Digite sua senha',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Confirmar',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    if (!password) {
                        Swal.showValidationMessage('A senha é obrigatória!');
                        return false;
                    }

                    // Fazer o fetch para enviar a senha
                    return fetch("{{ route('user.destroy') }}", {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            body: JSON.stringify({
                                password: password // Enviando a senha no corpo
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Falha na requisição');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status) {
                                Swal.fire(
                                        'Excluído!',
                                        'O usuário foi excluído com sucesso.',
                                        'success')
                                    .then(() => {
                                        window.location.href = "{{ route('login') }}";
                                    });
                            } else {
                                Swal.fire('Erro!', 'Senha incorreta ou falha ao excluir.', 'error');
                            }
                        })
                        .catch(err => {
                            Swal.fire('Erro!', 'Houve um problema ao processar a solicitação.',
                                'error');
                        });
                }
            });
        });
    </script>
@endsection
