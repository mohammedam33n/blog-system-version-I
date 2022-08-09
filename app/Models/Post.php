<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Category;
use App\Models\PostMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Post extends Model
{
    use HasFactory, Sluggable, SearchableTrait;
    protected $guarded = [];

    const Post_PATH = 'images/posts/';
    const Post_Defualt = 'post.png';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    protected $searchable = [
        'columns'   => [
            'posts.title'       => 10,
            'posts.description' => 10,
        ],
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopePost($query)
    {
        return $query->where('post_type', 'post');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approved_comments()
    {
        return $this->hasMany(Comment::class)->whereStatus(1);
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }

    public function status()
    {
        return $this->status == '1' ? 'Active' : 'Inactive';
    }
}
