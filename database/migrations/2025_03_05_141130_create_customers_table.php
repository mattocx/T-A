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
        Schema::create('customers', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('role')->default('customer');
            $table->string('nik');
            $table->string('address');
            $table->string('phone');
            $table->string('photo')->nullable();
            $table->enum('network_type', ['Fiber', 'Wireless']);
            $table->date('installation_date');
            $table->string('package_id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
