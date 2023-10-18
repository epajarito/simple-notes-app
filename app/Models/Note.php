<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
class Note extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'favorite'
    ];


    public function getRouteKeyName(): string
    {
        return "slug";
    }

    /**
     * Relationship with User model
     *
     * @return BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function scopeYear(Builder $query, string $value): Builder
    {
        return $query->whereYear('created_at', $value);
    }

    public function scopeMonth(Builder $query, string $value): Builder
    {
        return $query->whereMonth('created_at', $value);
    }


    /**
     * Attribute to get model type for resource
     *
     * @return string
    */
    public function getResourceTypeAttribute(): string
    {
        $model = Str::of(self::class)
            ->explode('\\')
            ->last();

        return str($model)->lower()->plural();
    }
}
