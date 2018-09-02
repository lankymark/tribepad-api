<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferencesAPIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'reference'     => $this->reference,
            'email'         => $this->email,
            'created_at'    => date('d/m/Y H:i:s', strtotime($this->created_at)),
            'updated_at'    => date('d/m/Y H:i:s', strtotime($this->updated_at)),
        ];
    }

    public function with($request) {
        return [
            'version'   => '1.0.0',
            'author'    => 'Mark Basford'
        ];
    }
}
