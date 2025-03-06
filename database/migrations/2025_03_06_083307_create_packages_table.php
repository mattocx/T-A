<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama paket (INET 4, INET 6, dll.)
            $table->decimal('price', 10, 2); // Harga paket
            $table->text('description')->nullable(); // Keterangan paket
            $table->integer('duration')->default(30); // Durasi paket dalam hari (default 30)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
