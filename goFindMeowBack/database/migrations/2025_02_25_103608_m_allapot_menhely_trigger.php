<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
{
    DB::unprepared(
        "CREATE TRIGGER createShelteredCatAfterReportInsert
        AFTER INSERT ON reports
        FOR EACH ROW
        BEGIN 
            IF NEW.status = 'm' THEN
                INSERT INTO sheltered_cats (rescuer, report, owner, s_status, chip_number, breed)
                VALUES (NEW.creator_id, NEW.report_id, NULL, NULL, NULL, NULL);
            END IF;
        END"
    );
}

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS createShelteredCatAfterReportInsert");
    }
    
};