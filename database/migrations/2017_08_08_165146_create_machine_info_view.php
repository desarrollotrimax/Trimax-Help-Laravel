<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachineInfoView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW machine_info AS
            SELECT m.serial_number, mm.model, mt.type, m.state
            FROM machines AS m 
            INNER JOIN machine_models AS mm ON m.model_id = mm.id
            INNER JOIN machine_types AS mt ON mm.type_id = mt.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW machine_info");
    }
}
