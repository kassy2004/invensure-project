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
        Schema::create('truck', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();        // e.g. ABC-1234
            $table->string('model')->nullable();             // e.g. Isuzu Elf
            $table->string('type')->nullable();              // e.g. 10-wheeler, closed van, etc.
            $table->integer('capacity_kg')->nullable();      // carrying capacity in kilograms
            $table->string('status')->default('available');  // available, under_maintenance, on_delivery
            $table->string('driver_name')->nullable();
            $table->string('driver_contact')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck');
    }
};
