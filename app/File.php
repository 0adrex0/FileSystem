<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //Tabel Name
    protected $table = 'files';
    // Primary Key 
    protected $primaryKey = 'id';
    // TimeStamps
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User');
    }

}
