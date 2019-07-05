<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'weights';

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
    protected $fillable = ['value'];

    
}
