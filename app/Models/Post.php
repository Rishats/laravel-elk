<?php

namespace App\Models;

use App\Configurators\PostIndexConfigurator;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use ScoutElastic\Searchable;

class Post extends Model
{
    use Sluggable;
    use Searchable;

    protected $indexConfigurator = PostIndexConfigurator::class;

    protected $searchRules = [
        //
    ];

    // Here you can specify a mapping for a model fields.
    protected $mapping = [
        'properties' => [
            'id' => [
                'type' => 'integer',
            ],
            'author_id' => [
                'type' => 'integer',
            ],
            'title' => [
                'type' => 'text',
                'analyzer' => 'english'
            ],
            'slug' => [
                'type' => 'text',
                'analyzer' => 'english'
            ],
            'description' => [
                'type' => 'text',
                'analyzer' => 'english'
            ],
            'body' => [
                'type' => 'text',
                'analyzer' => 'english'
            ]
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'slug', 'title', 'description', 'body',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get author of the post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Models\Author');
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
