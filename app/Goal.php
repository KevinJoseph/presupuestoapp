<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    //

    public function office(){
        return $this->hasMany('App\Office', 'id', 'office_id');
    }
}
