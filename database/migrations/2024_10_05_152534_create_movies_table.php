<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\AgeRating;
use App\Enums\Language;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id('movies_id');
            $table->string('title', 255);
            $table->text('description');
            $table->enum('age_rating', [implode("', '", array_column(AgeRating::cases(), 'value'))])->default(AgeRating::Rate_16->value);
            $table->enum('lang', [implode("', '", array_column(Language::cases(), 'value'))])->default(Language::Hun->value);
            $table->string('cover_img', 255)->nullable();
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
