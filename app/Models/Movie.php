<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AgeRating;
use App\Enums\Language;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';
    protected $primaryKey = 'movies_id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'movies_id',
        'title',
        'description',
        'age_rating',
        'lang',
        'cover_img',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'age_rating' => AgeRating::class,
        'lang' => Language::class,
    ];

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class, 'movies_id');
    }
}
