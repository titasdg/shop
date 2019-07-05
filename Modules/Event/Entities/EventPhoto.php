<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model
{
      /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event_photo';

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
    protected $fillable = ['event_id', 'image'];

}
