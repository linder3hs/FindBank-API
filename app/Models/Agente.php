<?php

namespace App\Models;

use App\Models\UserAgente;

use Illuminate\Database\Eloquent\Model;

class Agente extends Model {
    protected $table = 'agentes';
    public $timestamps = false;
    protected $fillable = array('nombre','direccion','lat','lng','tipo', 'sistema', 'seguridad', 'horario','descripcion');
    
    public function useragentes() {
        return $this->hasMany(UserAgente::class);
    }
    
}
