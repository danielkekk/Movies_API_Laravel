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
        Schema::create('screenings', function (Blueprint $table) {
            $table->id('screenings_id');
            $table->foreignId('movies_id')->nullable();
            $table->foreign('movies_id')
                  ->references('movies_id')
                  ->on('movies')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->dateTime('screeining_time');
            $table->integer('available_seats')->default(100);
            $table->string('url', 255)->nullable();
            $table->timestamps();

            $table->index(['screeining_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('screenings', function($table)
        {
            $table->dropForeign('screenings_movies_id_foreign');
            $table->dropIndex(['screeining_time']);
        });

        Schema::dropIfExists('screenings');
    }
};
