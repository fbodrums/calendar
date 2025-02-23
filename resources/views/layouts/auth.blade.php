<html lang="pt_BR" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('site/img/favicon_hc.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('site/img/favicon_hc.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('site/img/favicon_hc.png') }}">
    <link rel="mask-icon" href="{{ asset('site/img/favicon_hc.png') }}" color="#e98100">

    <title>Login</title>

    <link rel="icon" type="image/png"" href="{{ asset('assets/images/favicon.png') }}" sizes="16x16">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/apexcharts.css') }}">
    <!-- Data Table css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/dataTables.min.css') }}">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor-katex.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.atom-one-dark.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.quill.snow.css') }}">
    <!-- Date picker css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
    <!-- Calendar css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/full-calendar.css') }}">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/jquery-jvectormap-2.0.5.css') }}">
    <!-- Popup css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/magnific-popup.css') }}">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/slick.css') }}">
    <!-- prism css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/prism.css') }}">
    <!-- file upload css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/file-upload.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/lib/audioplayer.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .image-login {
            background-image: url("{{ asset('/assets/images/auth/login-bg.jpg') }}");
            background-position: center;
            background-size: cover;
        }

        #password-strength-meter {
            height: 8px;
            border-radius: 5px;
            background-color: #e0e0e0;
        }

        #password-strength-bar {
            height: 100%;
            width: 0%;
            /* Inicialmente 0% */
            border-radius: 5px;
            transition: width 0.3s ease-in-out;
        }
    </style>
</head>

<body>
    @yield('content')

    <!-- jQuery library js -->
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- Apex Chart js -->
    <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>
    <!-- Data Table js -->
    <script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
    <!-- Iconify Font js -->
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <!-- jQuery UI js -->
    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
    <!-- Vector Map js -->
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Popup js -->
    <script src="{{ asset('assets/js/lib/magnifc-popup.min.js') }}"></script>
    <!-- Slick Slider js -->
    <script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>
    <!-- prism js -->
    <script src="{{ asset('assets/js/lib/prism.js') }}"></script>
    <!-- file upload js -->
    <script src="{{ asset('assets/js/lib/file-upload.js') }}"></script>
    <!-- audioplayer -->
    <script src="{{ asset('assets/js/lib/audioplayer.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <script>
        // altera o status do senha de visivel/oculto
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on('click', function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }

        initializePasswordToggle('.toggle-password');

        $('.back-to-forgot-password').on('click', function() {
            $('#login').removeClass('d-flex').addClass('d-none');
            $('#signup').removeClass('d-flex').addClass('d-none');
            $('#forget-pass').removeClass('d-none').addClass('d-flex');
        });

        $('.back-to-login').on('click', function() {
            $('#forget-pass').removeClass('d-flex').addClass('d-none');
            $('#signup').removeClass('d-flex').addClass('d-none');
            $('#login').removeClass('d-none').addClass('d-flex');
        });

        $('.back-to-signup').on('click', function() {
            $('#forget-pass').removeClass('d-flex').addClass('d-none');
            $('#login').removeClass('d-flex').addClass('d-none');
            $('#signup').removeClass('d-none').addClass('d-flex');
        });


        // Função para mostrar a força da senha e preencher a barrinha
        function updatePasswordStrength() {
            var password = $('#passwordSignup').val();
            var strengthMeterBar = $('#password-strength-bar');
            var strengthText = $('#password-strength-text');
            var strength = 0;

            // Condições para aumentar a força da senha
            if (password.length >= 8) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[a-z]/.test(password)) strength += 1;
            if (/\d/.test(password)) strength += 1;
            if (/[\W_]/.test(password)) strength += 1;

            // Atualiza a barra e o texto de força
            switch (strength) {
                case 0:
                    strengthMeterBar.removeClass().addClass('bg-danger').width('0%');
                    strengthText.text('')

                    break;
                case 1:
                    strengthMeterBar.removeClass().addClass('bg-danger').width('20%');
                    strengthText.text('Fraca').css('color', '#ff4d4d');
                    break;
                case 2:
                    strengthMeterBar.removeClass().addClass('bg-warning').width('40%');
                    strengthText.text('Média').css('color', '#ffbf00');
                    break;
                case 3:
                    strengthMeterBar.removeClass().addClass('bg-info').width('60%');
                    strengthText.text('Boa').css('color', '#9ec5fe');
                    break;
                case 4:
                    strengthMeterBar.removeClass().addClass('bg-success').width('80%');
                    strengthText.text('Muito Boa').css('color', '#33cc33');
                    break;
                case 5:
                    strengthMeterBar.removeClass().addClass('bg-success').width('100%');
                    strengthText.text('Excelente').css('color', '#339966');
                    break;
            }
        }

        // Verificar se as senhas coincidem
        $('#passwordSignup, #passwordConfirm').on('input', function() {
            var password = $('#passwordSignup').val();
            var passwordConfirm = $('#passwordConfirm').val();

            if (password !== passwordConfirm) {
                $('#passwordConfirm').get(0).setCustomValidity('As senhas não coincidem.');
            } else {
                $('#passwordConfirm').get(0).setCustomValidity('');
            }

            updatePasswordStrength(); // Atualiza a força da senha durante a digitação
        });
    </script>
    @yield('scripts')
</body>

</html>
