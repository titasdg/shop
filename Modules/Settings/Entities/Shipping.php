<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shippings';

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
    protected $fillable = ['title', 'price', 'days'];

    
}
