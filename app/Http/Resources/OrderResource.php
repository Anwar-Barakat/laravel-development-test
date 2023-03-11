<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'user'          => new UserResource($this->user),
            'products'      => ProductResource::collection(Product::whereIn('id', $this->products)->get()),
            'price'         => $this->price,
            'payment_type'  => new PaymentResource($this->payment),
            'created'       => $this->created_at->diffForHumans()
        ];
    }
}
