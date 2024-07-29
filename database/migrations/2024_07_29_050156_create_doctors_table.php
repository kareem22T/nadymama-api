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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('specialization');
            $table->string('degree');
            $table->decimal('examination_price', 8, 2);
            $table->decimal('special_examination_price', 8, 2);
            $table->string('way_of_waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
