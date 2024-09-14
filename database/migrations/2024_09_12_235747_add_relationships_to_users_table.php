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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('kelas_id')->nullable()->after('id');
            $table->unsignedBigInteger('tingkat_kelas_id')->nullable()->after('kelas_id');
            $table->unsignedBigInteger('mata_pelajaran_id')->nullable()->after('tingkat_kelas_id');
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('mata_pelajaran_id');

            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('set null');
            $table->foreign('tingkat_kelas_id')->references('id')->on('tingkat_kelas')->onDelete('set null');
            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajarans')->onDelete('set null');
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['tingkat_kelas_id']);
            $table->dropForeign(['mata_pelajaran_id']);
            $table->dropForeign(['jurusan_id']);

            $table->dropColumn(['kelas_id', 'tingkat_kelas_id', 'mata_pelajaran_id', 'jurusan_id']);
        });
    }
};
