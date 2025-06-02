<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            CREATE FUNCTION getGenderCode(code CHAR(1))
            RETURNS CHAR(20) DETERMINISTIC
            BEGIN
                RETURN CASE
                    when code = 'L' then 'Laki-laki'
                    when code = 'P' then 'Perempuan'
                    Else 'tidak diketahui'
                END;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getGenderCode');
    }
};