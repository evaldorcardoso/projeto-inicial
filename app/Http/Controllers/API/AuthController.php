<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Registra um usuário
     * 
     * @param App\Http\Requests\AuthRegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(AuthRegisterRequest $request)
    {    
        $request['password'] = bcrypt($request->password);
        try{
            $user = User::create($request->toArray());
            Log::info('Novo usuário registrado com sucesso! Código gerado: '.$user->id);
            $accessToken = $user->createToken('authToken')->accessToken;

            return response([ 'user' => $user, 'access_token' => $accessToken]);
        }catch(\Exception $e){
            Log::error('Não foi possível registrar o Usuário: '.$e->getMessage());
            return response(['message' => 'Não foi possível registrar o Usuário']);
        }
    }

    /**
     * Loga o usuário de acordo com os dados informados, gera e retorna um novo access_token
     * 
     * @param App\Http\Requests\AuthLoginRequest;
     * @return \Illuminate\Http\Response
     */
    public function login(AuthLoginRequest $request)
    {        
        try{
            if (!auth()->attempt($request->toArray())) {
                return response()->json([
                    'success' => false,
                    'errors' => [ 'message' => 'Verifique seu login e senha' ]
                ], 422);
            }
            Log::info('Usuário '.auth()->user()->id.' logado com sucesso! ');
            $accessToken = auth()->user()->createToken('authToken')->accessToken;

            return response(['user' => auth()->user(), 'access_token' => $accessToken]);        
        }catch(\Exception $e){
            Log::error('Não foi possível efetuar o login com o usuário '.auth()->user()->id.': '.$e->getMessage());
            return response(['message' => 'Não foi possível efetuar o login com o usuário']);
        }
    }

    /**
     * Desloga o usuário revogando o token gerado anteriormente
     * 
     * @param Illuminate\Http\Request;
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try{
            $token = $request->user()->token();
            $token->revoke();
            Log::info('Usuário '.$request->user()->id.' deslogado com sucesso! ');
            return response(['message' => 'Deslogado com sucesso']);
        }catch(\Exception $e){
            Log::error('Não foi possível deslogar o usuário '.$request->user()->id.': '.$e->getMessage());
            return response(['message' => 'Não foi possível deslogar o usuário']);
        }
    }

}
