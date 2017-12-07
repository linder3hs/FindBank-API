<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\User;
use App\Models\UserAgente;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UsersController extends Controller {
    
    //Muestra todos los usuarios con tipo cliente
    public function index() {
    	$usuarios = User::where('tipo', 'cliente')->orderBy("nombre")->get();
        return $usuarios;
    }
    
    //Login de Usuarios
    public function login(Request $request) {
        try{
            $email = $request->get('email');
            $password = $request->get('password');
            $tipo = $request->get('tipo');//Tipos de usuarios: cliente - propietario - eliminado
            
            if (!$request->has('email') || !$request->has('password') || !$request->has('tipo')) {
                throw new \Exception('Campos mandatorios');
                
            } else {
                $userRecord = DB::table('users')->where('email', $email)->where('password', $password)->where('tipo', $tipo)->first();
                
                if ($userRecord==null) {
                    throw new \Exception('Usuario no existe');
                }else {
                    return response()->json(['type' => 'success', 'message' => 'Usuario valido'], 200);
                }
            }
            
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }

    }
    
    //Registro de Usuarios
    public function store(Request $request) {
        try{
            if(!$request->has('nombre') || !$request->has('email') || !$request->has('password') || !$request->has('tipo')){
                throw new \Exception('Campos mandatorios');
            }
            
            $usuario = new User();
            $usuario->nombre = $request->get('nombre');
    		$usuario->email = $request->get('email');
    		$usuario->password = $request->get('password');
    		$usuario->imagen = 'ic_user.png';
    		$usuario->tipo = $request->get('tipo');
    		
    		$usuario->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    //Eiminacion de Usuario
    public function destroy($id) {
        try {
            $usuario = User::find($id);
            
            if($usuario == null)
                throw new \Exception('Usuario no encontrado');
    		
    		if(Storage::disk('images')->exists($usuario->imagen))
    		    Storage::disk('images')->delete($usuario->imagen);
    		
    		$usuario->delete();
    		
            return response()->json(['type' => 'success', 'message' => 'Registro eliminado'], 200);
    	    
        }catch(\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    //Cambiar los datos de un usuario
    public function update(Request $request, $id) {
        try{
            $usuario = User::find($id);
            
            $usuario->nombre = $request->get('nombre');
    		$usuario->email = $request->get('email');
    		
    		if($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
    		    $imagen = $request->file('imagen');
        		$filename = $request->file('imagen')->getClientOriginalName();
        		
        		Storage::disk('images')->put($filename,  File::get($imagen));
        		
        		$producto->imagen = $filename;
    		}

    		$usuario->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    //Muestra los datos de un Usuario
    public function show($email) {
        try {
            $usuario = User::where('email', $email)->first();
            return $usuario;
            
        } catch(\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
}
