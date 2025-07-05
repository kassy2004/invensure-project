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
        Schema::create('truck_loading', function (Blueprint $table) {
            $table->id();
            $table->integer('truck_id');
            $table->integer('allocation_id');
            $table->string('status')->default('in_transit');
            $table->integer('loaded_weight')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_loading');
    }
};
