<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Screening extends Model
{
    use HasFactory;

    protected $table = 'screenings';
    protected $primaryKey = 'screenings_id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'screenings_id',
        'movies_id',
        'screeining_time',
        'available_seats',
        'url',
    ];

    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movies_id');
    }

    protected function screeiningTime(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('M d Y, H:i'),
        );
    }
}
