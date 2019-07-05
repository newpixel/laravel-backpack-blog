<?php

namespace Newpixel\BlogCRUD\app\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogArticle extends Model
{
    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'blog_articles';
    public static $status = ['draft' => 'Ciorna', 'published' => 'Publicat', 'private' => 'Privat'];
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'author_id', 'author_id', 'content', 'feature_image', 'status', 'meta', 'slug'];
    // protected $hidden = [];
    protected $fakeColumns = ['meta'];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'meta' => 'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function sluggable()
    {
        return [
            'slug' => [ 'source' => 'slug_or_name'],
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function categories()
    {
        return $this->belongsToMany('Newpixel\BlogCRUD\app\Models\BlogCategory', 'blog_categories_has_articles')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany('Newpixel\BlogCRUD\app\Models\BlogTag', 'blog_articles_has_tags')->withTimestamps();
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getSlugOrNameAttribute()
    {
        ($this->slug != '') ? $slug = $this->slug : $slug = $this->name;
        return $slug;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
