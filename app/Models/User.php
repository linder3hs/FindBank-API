<?php

namespace App\Models;

use App\Models\UserAgente;

use Illuminate\Database\Eloquent\Model;


class User extends Model {
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = array('nombre','email','password','imagen','tipo');
    //Ocultar las contraseñas
    protected $hidden = ['created_at', 'updated_at','password'];
    
    public function useragentes() {
        return $this->hasMany(UserAgente::class);
    }
    
}
