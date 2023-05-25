<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use function Composer\Autoload\includeFile;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'category_id', 'published_at'];
// search query

    public static function booted()
    {
        static::creating(function ($post) {
            if (auth()->check()) {
                $post->user_id = auth()->id();
            }
        });

        static::saving(function ($post) {
            $post->excerpt = $post->excerpt ?? Str::excerpt($post->body);

            // if title was changed
            if (isset($post->getDirty()['title'])) {
                $post->slug = Str::slug($post->title . ' ' . random_int(1, 10000));
            }
        });
    }

    public function scopeSearch($query, array $array)
    {
        if ($array['search'] ?? false) {
            $query
                ->where('title', 'like', '%' . $array['search'] . '%')
                ->orwhere('body', 'like', '%' . $array['search'] . '%');
        }
    }

    public function scopeDrafts($query)
    {
        $query-> whereNull('published_at');
    }
    public function scopePublished($query)
    {
        $query-> whereNotNull('published_at');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);// if I of id will be small then do not need to specify foreignKey It will auto render
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //@todo learn
    public function getPublishedAtAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value);
        }

        return null;
    }
    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }

}
