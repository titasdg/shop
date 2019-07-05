<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
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
            'name'=>$this->name,
            'last_name'=> $this->last_name,
            'email'=>$this->email,
            'mobile'=>$this->mobile,
            'done'=>$this->done,
            'created_at'=>$this->created_at,
        ];
    }
}
