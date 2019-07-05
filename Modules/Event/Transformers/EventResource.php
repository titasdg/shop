<?php

namespace Modules\Event\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Event\Entities\EventPhoto;

class EventResource extends Resource
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
            'date'=>$this->date,
            'time'=>$this->time,
            'created_at'=>$this->created_at,
            'photo'=>EventPhoto::where('event_id', $this->id)->get()
        ];
    }
}
