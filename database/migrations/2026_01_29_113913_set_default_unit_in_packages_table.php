<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Set default value unit menjadi 'kg'
        DB::statement("ALTER TABLE packages MODIFY COLUMN unit VARCHAR(255) NOT NULL DEFAULT 'kg'");
    }

    public function down(): void
    {
        // Hapus default value
        DB::statement("ALTER TABLE packages MODIFY COLUMN unit VARCHAR(255) NOT NULL");
    }
};
