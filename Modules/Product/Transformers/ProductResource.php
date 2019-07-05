<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Product\Entities\ProductPhoto;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'title'=>$this->title,
            'content'=> $this->content,
            'quantity'=>$this->quantity,
            'price'=>$this->price,
            'discount'=>$this->discount,
            'capacity'=>$this->capacity,
            'created_at'=>$this->created_at,
            'is_active'=>$this->is_active,
            'discount_price'=>$this->discount_price,
            'photo'=>ProductPhoto::where('product_id', $this->id)->get()
        ];
    }
}
