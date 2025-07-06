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
        Schema::create('pod', function (Blueprint $table) {
            $table->id();
            $table->string('pod_number');
            $table->string('name');
            $table->integer('order_id');
            $table->string('signature')->nullable();
            $table->string('type')->default('customer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pod');
    }
};
