<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachinesRoutines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $SQL = "
            CREATE FUNCTION get_type_id(in_name VARCHAR(45))
            RETURNS INT
            BEGIN
                RETURN (SELECT id FROM machine_types WHERE type=in_name);
            END
        ";
        DB::connection()->getPdo()->exec($SQL);

        $SQL = "
            CREATE FUNCTION get_model_id(in_name VARCHAR(45))
            RETURNS INT
            BEGIN
                RETURN (SELECT id FROM machine_models WHERE model=in_name);
            END
        ";
        DB::connection()->getPdo()->exec($SQL);


        $SQL = "
            CREATE PROCEDURE insert_machine (
                IN serial_number VARCHAR(24), IN  in_model VARCHAR(45), IN in_type VARCHAR(45)
            )
            BEGIN
                
                DECLARE type_id INT;
                DECLARE model_id INT;
                
                SELECT get_type_id(in_type) INTO type_id;
                IF type_id IS NULL THEN
                    INSERT INTO machine_types(type)
                    VALUES (in_type);
                    SELECT get_type_id(in_type) INTO type_id;
                END IF;
            
                SELECT get_model_id(in_model) INTO model_id;
                IF model_id IS NULL THEN
                    INSERT INTO machine_models(model, type_id)
                    VALUES (in_model, type_id);
                    SELECT get_model_id(in_model) INTO model_id;
                END IF;
                
                INSERT INTO machines (serial_number, model_id, state)
                VALUES (serial_number, model_id, 1);
                
            END
        ";
        DB::connection()->getPdo()->exec($SQL);

        $SQL = "
            CREATE PROCEDURE machine_manager (
                IN in_serial_number VARCHAR(24), IN in_model VARCHAR(45), IN in_type VARCHAR(45)
            )
            BEGIN
                
                UPDATE machines SET state=1 WHERE serial_number=in_serial_number;
                
                IF ROW_COUNT() != 1 THEN
                    CALL insert_machine(in_serial_number, in_model, in_type);
                END IF;
                
            END
        ";
        DB::connection()->getPdo()->exec($SQL);


        $SQL = "
            CREATE PROCEDURE set_inactive_machines()
            BEGIN
                SET SQL_SAFE_UPDATES = 0;
                UPDATE machines SET state = 0;
                SET SQL_SAFE_UPDATES = 1;
            END
        ";
        DB::connection()->getPdo()->exec($SQL);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $SQL = "DROP FUNCTION get_type_id";
        DB::connection()->getPdo()->exec($SQL);

        $SQL = "DROP FUNCTION get_model_id";
        DB::connection()->getPdo()->exec($SQL);


        $SQL = "DROP PROCEDURE insert_machine";
        DB::connection()->getPdo()->exec($SQL);

        $SQL = "DROP PROCEDURE machine_manager";
        DB::connection()->getPdo()->exec($SQL);


        $SQL = "DROP PROCEDURE set_inactive_machines";
        DB::connection()->getPdo()->exec($SQL);
    }
}
