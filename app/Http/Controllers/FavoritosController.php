<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\Agente;
use App\Models\UserAgente;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FavoritosController extends Controller {
    
    public function validacion(Request $request) {
        try{
            $user_id = $request->get('user_id');
            $agente_id = $request->get('agente_id');
            
            $userRecord = UserAgente::where('user_id', $user_id)->where('agente_id', $agente_id)->first();
                
            if ($userRecord==null) {
                throw new \Exception('Error');
            }else {
                return response()->json(['type' => 'success', 'message' => 'Favorito'], 200);
            }
            
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    //Muestra los favoritos de un usuario
    public function show($id) {
        try {
            $favoritos = UserAgente::select('users.id','agentes.id','agentes.nombre','agentes.direccion','agentes.sistema','agentes.seguridad','agentes.imagen')
                                    ->join('users', 'users_has_agentes.user_id', '=', 'users.id')
                                    ->join('agentes', 'users_has_agentes.agente_id', '=', 'agentes.id')
                                    ->where('users.id', $id)
                                    ->get();
            return $favoritos;
            
        } catch(\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    //Guarda los favoritos de un usuario
    public function store(Request $request) {
        try{
            if(!$request->has('user_id') || !$request->has('agente_id')){
                throw new \Exception('Campos mandatorios');
            }
            
            $favorito = new UserAgente();
            $favorito->user_id = $request->get('user_id');
            $favorito->agente_id = $request->get('agente_id');
            
            $favorito->save();
            
            return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
            
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    //Elimina los favoritos de un usuario
    public function destroyFavorito(Request $request) {
        try {
            if(!$request->has('user_id') || !$request->has('agente_id')){
                throw new \Exception('Campos mandatorios');
            }
            
            $user_id = $request->get('user_id');
            $agente_id = $request->get('agente_id');
            
            $favorito = UserAgente::where('user_id', $user_id)->where('agente_id', $agente_id)->delete();

            //return $favorito;
    		
            return response()->json(['type' => 'success', 'message' => 'Favorito eliminado'], 200);
    	    
        }catch(\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
}
