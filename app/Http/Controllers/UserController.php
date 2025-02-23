<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function index()
    {
        $user = $this->user;
        return view('user.index', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request)
    {
        try {
            $user = $this->user;
            foreach ($request->validated() as $key => $value) {
                $user->{$key} = $value;
            }

            $user->save();
            return Response::redirect('user.show');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = $this->user; // Pega o usuário autenticado
        $password = $request->input('password');

        // Verifica se a senha está correta
        if (Hash::check($password, $user->password)) {
            $user->delete();
            Auth::logout();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Senha incorreta'], 401);
    }
}
