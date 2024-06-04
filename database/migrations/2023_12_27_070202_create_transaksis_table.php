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
            $table->foreign('user_id')->references('id')->on('siswas');

            // Relation To Buku Table
            $table->unsignedBigInteger('buku_id');
            $table->foreign('buku_id')->references('id')->on('bukus');

            $table->integer('qty')->default(1);
            $table->string('status')->default('pending');
            $table->string('reject_reason')->nullable();
            $table->date('tgl_pinjam')->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->boolean('is_reviewed')->default(0);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });

        // Add trigger for setting the return date
        DB::statement("
        CREATE OR REPLACE FUNCTION after_peminjaman()
        RETURNS TRIGGER AS $$
        BEGIN
            IF OLD.status = 'Pending' AND NEW.status = 'approved' THEN
                UPDATE bukus
                SET stok_buku = stok_buku - 1
                WHERE id = NEW.buku_id;

                -- Update tanggal peminjaman
                UPDATE transaksis
                SET tgl_pinjam = now()
                WHERE id = NEW.id;

                UPDATE transaksis
                SET tgl_kembali = now() + INTERVAL '7 days'
                WHERE id = NEW.id;
            ELSIF OLD.status = 'approved' AND NEW.status = 'Dikembalikan' THEN
                UPDATE bukus
                SET stok_buku = stok_buku + 1
                WHERE id = NEW.buku_id;

                -- Update tanggal pengembalian
                UPDATE transaksis
                SET tgl_kembali = now()
                WHERE id = NEW.id;
            END IF;

            RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;
        ");

        DB::statement('
            CREATE TRIGGER after_peminjaman
            AFTER UPDATE ON transaksis
            FOR EACH ROW
            EXECUTE FUNCTION after_peminjaman();

        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
