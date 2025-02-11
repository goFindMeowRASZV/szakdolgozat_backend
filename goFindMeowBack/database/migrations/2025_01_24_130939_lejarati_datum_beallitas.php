<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void{
        DB::unprepared('
            CREATE TRIGGER lejarati_datum_beallitas
            BEFORE INSERT ON reports
            FOR EACH ROW
            BEGIN
                IF NEW.expiration_date IS NULL THEN
                    SET NEW.expiration_date = DATE_ADD(NEW.created_at, INTERVAL 14 DAY);
                END IF;
            END;
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS lejarati_datum_beallitas');
    }
};






