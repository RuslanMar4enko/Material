<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $request->id,
            'address' => $request->address,
            'full_name' => $request->full_name,
            'delivery' => $request->delivery,
            'phone' => $request->phone,
        ];
    }
}
