<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderedProduct extends Model
{ /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'ordered_product';

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
   protected $fillable = ['order_id','product_id','quantity'];
}
