<?php

use App\Models\Cabinet;
use App\Models\Floor;
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
        Schema::create('floor_cabinets', function (Blueprint $table) {
            $table->foreignIdFor(Floor::class);
            $table->foreignIdFor(Cabinet::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floor_cabinets');
    }
};
