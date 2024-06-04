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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            // Relation To Siswa Table
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('siswas');

            // Relation To Buku Table
            $table->unsignedBigInteger('buku_id');
            $table->foreign('buku_id')->references('id')->on('bukus');
            $table->text('ulasan');
            $table->integer('rating');
            $table->timestamps();
        });

        DB::statement("
            ALTER TABLE bukus
            ADD COLUMN average_rating NUMERIC(3, 2) DEFAULT 0.00;
        ");
        DB::statement("
            CREATE OR REPLACE FUNCTION update_average_rating()
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE bukus
                SET average_rating = (
                    SELECT AVG(rating)::NUMERIC(3, 2)
                    FROM ulasan
                    WHERE buku_id = NEW.buku_id
                )
                WHERE id = NEW.buku_id;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::statement("
            CREATE TRIGGER update_average_rating_trigger
            AFTER INSERT OR UPDATE OR DELETE ON ulasan
            FOR EACH ROW
            EXECUTE FUNCTION update_average_rating();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
