@extends('layouts.auth')

@section('content')
    <section class="auth bg-base d-flex flex-wrap">
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center image-login">
            </div>
        </div>


        <div id="login" class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <a href="#" class="mb-40 max-w-290-px">
                        <img src="{{ asset('assets/images/logo.png') }}" alt=""></a>
                    <p class="mb-32 text-secondary-light text-lg">Bem vindo(a) de volta!</p>
                </div>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="icon-field mb-16">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:user"></iconify-icon>
                        </span>
                        <input type="text" name="email" class="form-control h-56-px bg-neutral-50 radius-12"
                            placeholder="E-mail" value="{{ old('email') }}">

                       
                    </div>

                    @error('email')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
                    <div class="position-relative mb-20">
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                            </span>

                            <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" name="password"
                                id="password" placeholder="Senha" value="{{ old('password') }}">

                            <div data-lastpass-icon-root=""
                                style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;">
                            </div>
                        </div>

                        <span
                            class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                            data-toggle="#password"></span>



                    </div>

                    @error('password')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror

                    @if (session('message'))
                        <div class="alert {{ session('status') ? 'alert-primary bg-primary-600 text-white border-primary-600' : 'alert-danger bg-danger-600 text-white border-danger-600' }}
                            px-24 py-11 mb-0 mt-3 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between"
                            role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    @error('email_recover')
                        <div class="alert alert-info mt-3">{{ $message }}</div>
                    @enderror
                    <div class="d-flex justify-content-between gap-2">
                        <div class="form-check style-check d-flex align-items-center">
                            <input class="form-check-input border border-neutral-300" type="checkbox" name="remember" value=""
                                id="remeber">
                            <label class="form-check-label" for="remeber">Lembrar credenciais </label>
                        </div>

                        <a href="#" class="text-primary-600 fw-medium back-to-forgot-password">Esqueceu a
                            senha?</a>
                    </div>

                    <button type="submit"
                        class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">Entrar</button>

                    <br />
                    <p class="text-center pt-3 login-content-link">
                        Não tem uma conta? <a href="#" class="back-to-signup text-especial">Clique aqui</a>
                    </p>
                </form>
            </div>
        </div>

        <div id="forget-pass" class="auth-right py-32 px-24 d-none flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <h4 class="mb-12">Esqueci a senha</h4>
                    <p class="mb-32 text-secondary-light text-lg">Insira o endereço de e-mail associado à sua conta e
                        lhe enviaremos um link para redefinir sua senha.</p>
                </div>
                <form id="resetPasswordForm" action="{{ route('forget-password') }}" method="POST">
                    @csrf
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:email"></iconify-icon>
                        </span>
                        <input name="email_recover" type="email"
                            class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Digite seu Email">
                    </div>
                    <button type="submit"
                        class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">Enviar</button>

                    <div class="text-center pt-3 ">
                        <a href="#" class="mt-24 back-to-login">Voltar para Login</a>
                    </div>

                </form>
            </div>
        </div>

        <!-- Div para Cadastro de Usuário -->
        <div id="signup" class="auth-right py-32 px-24 d-none flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <h4 class="mb-12">Criar Conta</h4>
                    <p class="mb-32 text-secondary-light text-lg">Preencha os dados abaixo para criar uma nova conta.
                    </p>
                </div>
                <form action="{{ route('signup') }}" method="POST">
                    @csrf
                    <div class="icon-field mb-16">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="bi:person-fill"></iconify-icon>
                        </span>
                        <input type="text" name="name" class="form-control h-56-px bg-neutral-50 radius-12"
                            placeholder="Nome" required>
                    </div>
                    <div class="icon-field mb-16">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:email"></iconify-icon>
                        </span>
                        <input type="email" name="email" class="form-control h-56-px bg-neutral-50 radius-12"
                            placeholder="E-mail" required>
                    </div>
                    <div class="position-relative mb-20">
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                            </span>
                            <input type="password" name="password" id="passwordSignup"
                                class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Senha" required>
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

                    <!-- Medidor de Força de Senha -->
                    <div id="password-strength-meter" class="mt-2"
                        style="height: 8px; border-radius: 5px; background-color: #e0e0e0;">
                        <div id="password-strength-bar" style="height: 100%; width: 0%; border-radius: 5px;">
                        </div>
                    </div>
                    <div id="password-strength-text" class="mt-1"></div>
                    <button type="submit"
                        class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">Cadastrar</button>

                    <div class="text-center pt-3">
                        <a href="#" class="back-to-login">Já
                            tem uma conta? Faça login</a>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection
