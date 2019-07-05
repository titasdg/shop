<?php

namespace Modules\Blog\Transformers;

use Modules\Blog\Entities\BlogPhoto;
use Illuminate\Http\Resources\Json\Resource;
class BlogResource extends Resource
{
    /**
     * Transform the resource collection into an array.
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
            'tag'=>$this->tag,
            'created_at'=>$this->created_at,
            'photo'=>BlogPhoto::where('blog_id', $this->id)->get()
        ];
    }
}
