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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('leave_type');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('reason');
            $table->string('additional_notes')->nullable();
            $table->string('supervisor_approval');
            $table->string('management_approval');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
