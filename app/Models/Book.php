<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'category_id',
        'published_at',
        'is_active',
    ];

    protected $dates = ['published_at'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPublishedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function setPublishedAtAttribute($value): Carbon
    {
        return $this->attributes['published_at'] = Carbon::parse($value);
    }
}
