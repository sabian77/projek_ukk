<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER after_pkl_insert
            AFTER INSERT ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas 
                SET status_pkl = 1 
                WHERE id = NEW.siswa_id;
            END;
        ');

        DB::unprepared('
            CREATE TRIGGER after_pkl_delete
            AFTER DELETE ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas 
                SET status_pkl = 0 
                WHERE id = OLD.siswa_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_pkl_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_pkl_delete');
    }
};
