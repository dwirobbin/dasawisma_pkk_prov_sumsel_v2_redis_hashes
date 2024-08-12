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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_head_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nik_number')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->date('birth_date');
            $table->enum('status', ['Kepala Keluarga', 'Istri', 'Anak', 'Keluarga', 'Orang Tua']);
            $table->enum('marital_status', ['Kawin', 'Belum Kawin', 'Janda', 'Duda'])->default('Belum Kawin');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->enum('last_education', ['Belum/Tidak Sekolah', 'TK/PAUD', 'SD/MI', 'SLTP/SMP/MTS', 'SLTA/SMA/MA/SMK', 'Diploma', 'S1', 'S2', 'S3'])->default('Belum/Tidak Sekolah');
            $table->string('profession')->default('Belum/Tidak Bekerja');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
