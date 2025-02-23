@extends('layouts.auth')

@section('content')
    <section class="auth bg-base d-flex flex-wrap">
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center image-login">
            </div>
        </div>

        <!-- Div para Cadastro de Usuário -->
        <div id="signup" class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <h4 class="mb-12">Alterar Senha</h4>
                    <p class="mb-32 text-secondary-light text-lg">Digite a senha e confirme
                    </p>
                </div>
                <form action="{{ route('recover-password') }}" method="POST">
                    @csrf
                    <div class="position-relative mb-20">
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                            </span>
                            <input type="password" name="password" id="passwordSignup"
                                class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Nova Senha" required>
                        </div>
                        <span
                            class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                            data-toggle="#passwordSignup"></span>
                    </div>


                    <div class="position-relative mb-20">
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                            </span>
                            <input type="password" name="password_confirmation" id="passwordConfirm"
                                class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Confirmar Senha"
                                required>
                        </div>
                    </div>

                    <input type="hidden" value="{{ request()->token }}" name="token" />
                    <input type="hidden" value="{{ request()->email }}" name="email" />

                    <!-- Medidor de Força de Senha -->
                    <div id="password-strength-meter" class="mt-2"
                        style="height: 8px; border-radius: 5px; background-color: #e0e0e0;">
                        <div id="password-strength-bar" style="height: 100%; width: 0%; border-radius: 5px;">
                        </div>
                    </div>
                    <div id="password-strength-text" class="mt-1"></div>
                    <button type="submit"
                        class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">Alterar</button>
                </form>
            </div>
        </div>

    </section>
@endsection