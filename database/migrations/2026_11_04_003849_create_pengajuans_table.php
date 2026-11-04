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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengajuan')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jenis_layanan_id')->constrained('jenis_layanans')->onDelete('cascade');
            $table->string('status')->default('pending'); // Menandai status pengajuan: pending / approved / rejected
            $table->text('keterangan')->nullable(); // Menyimpan keterangan tambahan jika diperlukan
            $table->timestamps();
        });

        Schema::table('pengajuans', function (Blueprint $table) {
            $table->string('file_lampiran')->nullable()->after('keterangan');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
