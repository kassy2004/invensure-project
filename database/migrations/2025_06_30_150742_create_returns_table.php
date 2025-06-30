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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->string('prod_category')->nullable();
            $table->date('production_date');
            $table->integer('qty');
            $table->decimal('kilogram', 8, 2);
            $table->string('description')->nullable();
            $table->string('reason_for_return');
            $table->integer('pod_number');
            $table->string('warehouse');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
