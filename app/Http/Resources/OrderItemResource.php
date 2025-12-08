<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'dish_id' => $this->dish_id,
            'price'   => $this->price,
            'quantity'=> $this->quantity,
            'name'    => $this->dish->name,
            'image'   => asset('uploads/dishes/'.$this->dish->image),
        ];
    }
}

?>
