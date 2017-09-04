<?php

namespace TrimaxHelp;

use Illuminate\Database\Eloquent\Model;

class MachineModel extends Model
{
    protected $table = 'machine_models';
    protected $fillable = ['model', 'type_id'];

    protected $visible = ['model','type_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function type(){
         return $this->belongsTo('TrimaxHelp\MachineType');
    }
    public function machines(){
         return $this->hasMany('TrimaxHelp\Machine');
    }
}
