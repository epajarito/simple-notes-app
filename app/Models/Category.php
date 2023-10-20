<?php

namespace App\Models;

use App\Traits\HasAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,
        HasAttributes;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
