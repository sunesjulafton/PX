<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    

    public function permissions() {

        return $this->belongsToMany(Permission::class,'role_permission');
            
    }
     
    public function users() {
     
        return $this->belongsToMany(User::class,'user_role');
            
    }


}
