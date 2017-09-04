<?php

namespace TrimaxHelp;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'machines';
    protected $primaryKey = 'serial_number';
    public $incrementing = false;

    protected $visible = ['serial_number', 'state', 'model_id'];

    public function model(){
        return $this->belongsTo('TrimaxHelp\MachineModel');   
    }

}
