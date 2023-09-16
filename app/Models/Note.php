<?php

namespace App\Models;

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

    /**
     * Relationship with User model
     *
     * @return BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Attribute to get model type for resource
     *
     * @return string
    */
    public function getModelTypeAttribute(): string
    {
        $model = Str::of(self::class)
            ->explode('\\')
            ->last();

        return str($model)->lower()->plural();
    }
}
