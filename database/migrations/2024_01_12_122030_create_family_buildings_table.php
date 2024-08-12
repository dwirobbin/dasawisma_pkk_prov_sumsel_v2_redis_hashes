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
        Schema::create('family_buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_head_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('staple_food', ['Beras', 'Non Beras'])->nullable();
            $table->boolean('have_toilet')->default(false);
            $table->string('water_src');
            $table->boolean('have_landfill')->default(false);
            $table->boolean('have_sewerage')->default(false);
            $table->boolean('pasting_p4k_sticker')->default(false);
            $table->enum('house_criteria', ['Sehat', 'Kurang Sehat'])->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_buildings');
    }
};
