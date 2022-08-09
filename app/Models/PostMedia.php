<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;


class PostMedia extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }


}
