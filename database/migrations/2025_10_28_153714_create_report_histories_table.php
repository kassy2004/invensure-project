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
        Schema::create('report_histories', function (Blueprint $table) {
            $table->id();
            $table->string('report_name');
            $table->string('type'); // e.g., PDF, Excel
            $table->string('warehouse')->nullable();
            $table->string('file_url'); // Google Drive link
            $table->string('file_size')->nullable(); // e.g., "1.2 MB"
            $table->string('generated_by');
            $table->timestamp('generated_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_histories');
    }
};
