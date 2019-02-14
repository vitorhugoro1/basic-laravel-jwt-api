<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = ['post_title', 'post_name', 'content', 'user_id'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // When is creating an new Post is set this data automatic
        static::creating(function ($model) {
            $model->post_name = str_slug($model->post_title);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
