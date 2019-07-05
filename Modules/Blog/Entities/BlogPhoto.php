<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class BlogPhoto extends Model
{
       /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blog_photo';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['blog_id', 'image'];
}
