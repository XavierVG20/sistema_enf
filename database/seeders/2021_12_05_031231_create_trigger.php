<?php

use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    public function up()
    {
        DB::unprepared('
                CREATE TRIGGER tr_after_detalle_ventas_insert AFTER INSERT ON `detalle_ventas` FOR EACH ROW
                    BEGIN
                    update articulos set articulos.stock = articulos.stock - new.cantidad where articulos.id = new.idarticulo;
                    END
                ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_after_detalle_ventas_insert`');
    }
}