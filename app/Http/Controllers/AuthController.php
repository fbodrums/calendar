<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordChangeRequest;
use App\Http\Requests\Auth\PasswordRecoveryRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    // Login
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Validação do login e autenticação
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Verifica se o email foi validado
            if (!$user->email_verified_at) {
                Auth::logout(); // Desloga imediatamente
                return back()->withErrors(['usuario' => 'Seu e-mail ainda não foi verificado. Verifique sua caixa de entrada.']);
            }

            return Response::redirect(routeName: 'contact.show.all');
        }

        return Response::redirect(routeName: 'login.view', status: false, message: 'Credenciais incorretas.');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return Response::redirect(routeName: 'login.view');
    }

    // Enviar email para recuperação de senha
    public function sendPasswordResetLink(PasswordRecoveryRequest $request)
    {
        // Buscar o usuário pelo email
        $user = User::where('email', $request->email_recover)->first();

        // Verifica se o usuário existe
        if (!$user) {
            return Response::redirect(
                message: 'Não conseguimos encontrar um usuário com esse e-mail.',
                routeName: 'login.view',
                status: false
            );
        }

        // Enviar o link de recuperação de senha
        $status = Password::sendResetLink(['email' => $request->email_recover]);

        // Verifica se o link foi enviado com sucesso
        $linkSended = $status === Password::RESET_LINK_SENT;

        return Response::redirect(
            message: $linkSended ? 'O link de recuperação foi enviado para seu e-mail.' : 'Ocorreu um erro ao enviar o link de recuperação.',
            routeName: 'login.view',
            status: $linkSended
        );
    }

    public function signup(SignupRequest $request)
    {
        $redirectRoute = 'login.view';

        try {
            DB::beginTransaction();
            // Criação do usuário com os dados fornecidos
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Enviar e-mail de verificação
            $user->sendEmailVerificationNotification();

            DB::commit();

            return Response::redirect(message: 'Cadastro realizado com sucesso. Um link de ativação foi enviado para o seu e-mail.', routeName: $redirectRoute);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::redirect(message: $e->getMessage(), routeName: $redirectRoute, status: false);
        }
    }

    public function validateEmail(Request $request)
    {
        $user = User::findOrFail($request->id);
        $redirectRoute = 'login.view';

        // Verifique se o token corresponde ao do usuário
        if ($user->email_verification_token === $request->token) {
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            return Response::redirect(message: 'E-mail verificado com sucesso!', routeName: $redirectRoute);
        }

        return Response::redirect(message: 'Token de verificação inválido!', routeName: $redirectRoute, status: false);
    }

    /**
     * Processa a redefinição de senha.
     */
    public function resetPassword(PasswordChangeRequest $request)
    {
        $redirectRoute = 'login.view';

        // Verifica se o token é válido
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                // Atualiza a senha do usuário
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        // Verifica se a redefinição foi bem-sucedida
        if ($status === Password::PASSWORD_RESET) {
            return Response::redirect(message: 'Senha alterada com sucesso', routeName: $redirectRoute);
        }

        // Caso contrário, retorna com erro
        return Response::redirect(message: 'Problema ao alterar a senha', routeName: $redirectRoute);
    }

    public function showRecoverPassword($email, $token)
    {
        // Verifica se o token é válido
        $status = Password::tokenExists(User::where('email', $email)->first(), $token);

        if (!$status) {
            return Redirect::route('login.view')->with('error', 'O link de recuperação de senha expirou ou é inválido.');
        }

        // Exibe a view normalmente se o token for válido
        return view('auth.recover-password', compact('email', 'token'));
    }
}
