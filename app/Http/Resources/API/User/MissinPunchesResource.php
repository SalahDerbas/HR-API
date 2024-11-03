<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class MissinPunchesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        parent::toArray($request);
        return [
            'id'                      => $this['id'],
            'date'                    => formatDate($this['date']),
            'time'                    => $this['time'],
            'document'                => $this['document'],
            'reason'                  => $this['reason'],
            'user_id'                 => $this['user_id'],
            'type_missing_punch_id'   => $this['type_missing_punch_id'],
            'missing_punch_type'      => isset($this['type_missing_punch_id']) ? ((config('app_header.lang') == 'ar') ? $this['getMissingPunchType']['value_ar'] :$this['getMissingPunchType']['value_en']) : NULL,

        ];
    }
}
