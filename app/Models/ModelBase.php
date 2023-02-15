<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ModelBase extends Model{

    protected $primaryKey = 'id';

    //
    // In your model...
    public function isSoftDelete(){
        // ... check if 'this' model uses the soft deletes trait
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this)) && ! $this->forceDeleting;
    }
    
    public static function getChecksum($data){
        $val = '';

        foreach( $data->getFillable() as $fill )
        {
            $val .= $data->$fill . config('app.checksum_separator');
        }

        $val = substr($val, 0, -1);

        $ret = Uuid::uuid5(Uuid::NAMESPACE_X500, $val)->toString();

        return $ret;
    }
    
}