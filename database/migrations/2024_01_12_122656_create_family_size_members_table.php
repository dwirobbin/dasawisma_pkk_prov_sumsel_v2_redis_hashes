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
        Schema::create('family_size_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_head_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedTinyInteger('toddlers_number')->default(0);
            $table->unsignedTinyInteger('pus_number')->default(0);
            $table->unsignedTinyInteger('wus_number')->default(0);
            $table->unsignedTinyInteger('blind_people_number')->default(0);
            $table->unsignedTinyInteger('pregnant_women_number')->default(0);
            $table->unsignedTinyInteger('breastfeeding_mother_number')->default(0);
            $table->unsignedTinyInteger('elderly_number')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_size_members');
    }
};
