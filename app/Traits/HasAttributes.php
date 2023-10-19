<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasAttributes
{

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