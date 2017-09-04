<?php

namespace TrimaxHelp;

use Illuminate\Database\Eloquent\Model;

class MachineType extends Model
{
    protected $table = 'machine_types';

    public function models(){
        return $this->hasMany('TrimaxHelp\MachineModel');
    }
}
