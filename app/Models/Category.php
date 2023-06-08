<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->oldest('name');
        });
    }

    public static function all($columns = ['*'])
    {
        return cache()->rememberForever('categories', function () use ($columns)
        {
            return parent::all($columns);
        });
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
