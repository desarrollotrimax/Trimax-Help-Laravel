<?php

namespace TrimaxHelp\Http\Controllers;

use Illuminate\Http\Request;
use TrimaxHelp\Machine;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

class MachineController extends Controller
{
    public function show($serial_number){

        $machine = DB::table('machine_info')->where('serial_number', $serial_number)->first();
        $found = ($machine)? true : false;
        $response = ['found'=>$found];
        if($machine){
            $response+= [
                'serial_number' => $machine->serial_number,
                'state' => $machine->state,
                'model' => $machine->model,
                'icon' => asset('img/machines/'.$machine->type.'.png'),
            ];
        }

        return response($response, 200)
            ->withHeaders([
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers' => 'accept, Content-Type, x-xsrf-token, x-csrf-token',
                'Access-Control-Allow-Origin'  => '*'
            ]);
    }

    public function bulkUpdate(){
        $json = File::get("data/machines.json");
        
        $data = json_decode($json, true);

        if ( is_array($data['Output']) ){
            DB::statement("CALL set_inactive_machines();");
            $counter =0;
            foreach ( $data['Output'] as $machine) {
                DB::statement('CALL machine_manager("'.
                    $machine['SERIE'].'", "'.
                    $machine['MODELO'].'", "'.
                    title_case($machine['TIPO']).'");'
                );
                $counter +=1;
            }

        }
        dd('Se ha completado la actualización de '.$counter.' máquinas sin NINGÚN problema. ;)');
    }
}
