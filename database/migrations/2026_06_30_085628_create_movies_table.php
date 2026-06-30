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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('imdb_id')->unique();
            $table->string('title');
            $table->year('year')->nullable();
            $table->string('rated')->nullable();
            $table->date('released')->nullable();
            $table->unsignedInteger('runtime')->nullable();
            $table->string('director')->nullable();
            $table->text('plot')->nullable();
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->string('awards')->nullable();
            $table->string('poster')->nullable();
            $table->decimal('imdb_rating', 3, 1)->nullable();
            $table->unsignedInteger('imdb_votes')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
