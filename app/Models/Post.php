<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function Composer\Autoload\includeFile;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'category_id', 'published_at', 'thumbnail'];
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

            /** This condition is used to
                store the post thumbnail and save its path
                to the database to display the thumbnail along
                the posts where required
             */

            if (request()->hasFile('thumbnail')) {
                $post->thumbnail = request()->file('thumbnail')->store('thumbnails');
            }
        });
        static::deleting(function ($post) {
            if ($post->thumbnail) {
                Storage::delete($post->thumbnail);
            }
        });
    }

    public function scopeSearch($query, string $search)
    {
        $query->where('title', 'like', '%' . $search . '%')
                ->orwhere('body', 'like', '%' . $search . '%');
    }

    public function scopeDrafts($query)
    {
        $query-> whereNull('published_at');
    }

    public function scopePublished($query)
    {
        $query-> whereNotNull('published_at');
    }

    public function getThumbnail()
    {
        if ($this->thumbnail){
            return Storage::url($this->thumbnail);
        } else {
            return asset('/images/illustration-3.png');
        }
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
