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
        Schema::create('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('phone_number')->unique();
            $table->unsignedSmallInteger('province_id')->nullable();
            $table->unsignedInteger('regency_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedBigInteger('village_id')->nullable();

            $table->foreign('province_id')->references('id')->on('provinces')->restrictOnDelete();
            $table->foreign('regency_id')->references('id')->on('regencies')->restrictOnDelete();
            $table->foreign('district_id')->references('id')->on('districts')->restrictOnDelete();
            $table->foreign('village_id')->references('id')->on('villages')->restrictOnDelete();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
