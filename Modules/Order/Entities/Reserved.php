<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class Reserved extends Model
{
  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reserved';

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
    protected $fillable = ['customer_token', 'product_id', 'quantity'];
}
