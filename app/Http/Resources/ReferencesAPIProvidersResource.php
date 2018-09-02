<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferencesAPIProvidersResource extends JsonResource
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
            'reference'     => $this->reference,
            'provider'      => $this->provider,
            'status'        => $this->status,
            'score'         => $this->score,
            'failed'        => $this->failed,
            'created_at'    => date('d/m/Y H:i:s', strtotime($this->created_at)),
            'updated_at'    => date('d/m/Y H:i:s', strtotime($this->updated_at)),
        ];
    }
}
