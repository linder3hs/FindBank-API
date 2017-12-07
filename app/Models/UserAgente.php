<?php

namespace App\Models;

use App\Models\User;
use App\Models\Agente;

use Illuminate\Database\Eloquent\Model;

class UserAgente extends Model {
    protected $table = 'users_has_agentes';
    public $timestamps = false;
    protected $fillable = array('users_id','agentes_id');
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function agente(){
        return $this->belongsTo(Agente::class);
    }
    
    /*
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function agente(){
        return $this->belongsTo('App\Models\Agente', 'agente_id');
    }
    */
    
}
