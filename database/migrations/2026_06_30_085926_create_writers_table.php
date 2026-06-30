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
        Schema::create('writers', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('movie_writer', function (Blueprint $table) {
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('writer_id')->constrained()->cascadeOnDelete();

            $table->primary([
                'movie_id',
                'writer_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_writer');
        Schema::dropIfExists('writers');
    }
};
