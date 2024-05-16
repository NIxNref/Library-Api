<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            // Relation To Siswa Table
            $table->unsignedBigInteger('user_id');
            $table->string('name_user');
            // $table->foreign('siswa_id')->references('id')->on('siswas');

            // Relation To Buku Table
            $table->unsignedBigInteger('buku_id');
            $table->string('name_buku');

            // $table->foreign('buku_id')->references('id')->on('bukus');

            $table->integer('qty')->default(1);
            $table->string('status')->default('pending');
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
