<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PortofolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'image' => url('image_upload/'.$this->image),
            'address' => $this->address,
            'youtube' => $this->youtube,
            'softwares' => $this->softwares,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'theme' => $this->theme,
            'year' => $this->year,
            'date' => Carbon::parse($this->updated_at)->format('M Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
