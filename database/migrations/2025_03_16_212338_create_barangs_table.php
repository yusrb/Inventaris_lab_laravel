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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('name_barang');
            $table->unsignedBigInteger('kategori_id');
            $table->integer('jumlah')->default(0);
            $table->enum('kondisi', ['Baik', 'Rusak', 'Hilang'])->default('Baik');
            $table->integer('stok_minimum')->default('1');
            $table->text('deskripsi')->nullable();

            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
