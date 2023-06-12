<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->oldest('name');
        });
    }

    //@todo  learn this parent and columns concept
    public static function all($columns = ['*'])
    {
        return Cache::tags('categories')->rememberForever('categories', function () use ($columns)
        {
            return parent::all($columns);
        });
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
