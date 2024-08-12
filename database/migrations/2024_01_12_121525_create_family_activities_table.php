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
        Schema::create('family_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_head_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('up2k_activity')->nullable();
            $table->text('env_health_activity')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_activities');
    }
};
