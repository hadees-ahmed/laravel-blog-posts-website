<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'excerpt', 'body'];
// search query
    public function scopeSearch($query, array $array){
        if ($array['search'] ?? false) {
            $query
                ->where('title', 'like', '%' . $array['search'] . '%')
                ->orwhere('body', 'like', '%' . $array['search'] . '%');
        }
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);// if I of id will be small then do not need to specify foreignKey It will auto render
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    //@todo learn
    public function getPublishedAtAttribute($value)
    {
        return Carbon::parse($value);
    }
    function comments(){
        return $this->hasMany(Comment::class,'post_id');
    }
}
