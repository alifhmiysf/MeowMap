
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cat_spottings', function (Blueprint $table) {
            $table->softDeletes();
            $table->string('district')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('cat_spottings', function (Blueprint $table) {
            $table->dropColumn('district');
            $table->dropSoftDeletes();
        });
    }
};
