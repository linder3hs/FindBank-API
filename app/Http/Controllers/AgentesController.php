<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\Agente;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AgentesController extends Controller {
    
    public function index() {
        $agentes = DB::table('agentes')->orderBy("nombre")->get();
        return $agentes;
    }
    
    public function show($id) {
        try {
            $agente = Agente::find($id);
            return $agente;
            
        } catch(\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function store(Requests $request) {
        
        try{
            if(!$request->has('nombre') || !$request->has('direccion') || !$request->has('lat') || !$request->has('lng')){
                throw new \Exception('Campos mandatorios');
            }
            
            $agentes = new Agente();
            
            $agentes->nombre = $request->get('nombre');
            $agentes->direccion = $request->get('direccion');
            $agentes->lat = $request->get('lat');
            $agentes->lng = $request->get('lng');
            $agentes->tipo = $request->get('tipo');
            $agentes->sistema = $request->get('sistema');
            $agentes->seguridad = $request->get('seguridad');
            $agentes->horario = $request->get('horario');
            $agentes->descripcion = $request->get('descripcion');
            
            $agentes->save();
            
            return response()->json(['type' => 'success', 'message' => 'Datos Agentes'], 200);
            
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function update(Request $request, $id){
        try{
            $agente = Agente::find($id);
            
            $agente->sistema = $request->get('sistema');
    		$agente->seguridad = $request->get('seguridad');

    		$agente->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
}
