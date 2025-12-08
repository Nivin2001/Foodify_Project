<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'subtotal' => $this->subtotal,
            'delivery' => $this->delivery,
            'total'    => $this->total,
            'status'   => $this->status,

            'items' => OrderItemResource::collection($this->items)
        ];
    }
}
?>
