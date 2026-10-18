<?php

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
    Schema::table('cat_spottings', function (Blueprint $table) {
        $table->string('report_type', 20)->nullable();
    });
}

public function down(): void
{
    Schema::table('cat_spottings', function (Blueprint $table) {
        $table->dropColumn('report_type');
    });
}

};
