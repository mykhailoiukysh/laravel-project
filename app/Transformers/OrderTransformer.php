<?php

namespace DOLucasDelivery\Transformers;

use League\Fractal\TransformerAbstract;
use DOLucasDelivery\Models\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderTransformer
 * @package namespace DOLucasDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['coupon', 'items', 'client', 'deliveryman'];
    
    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'            => (int) $model->id,
            'total'         => (float) $model->total,
            'product_names' => $this->getArrayProductNames($model->items),
            'status'        => $model->status,
            'hash'          => $model->hash,
            'created_at'    => $model->created_at,
            'updated_at'    => $model->updated_at
        ];
    }
    
    protected function getArrayProductNames(Collection $items)
    {
        $names = [];
        foreach ($items as $item) {
            $names[] = $item->product->name;
        }
        return $names;
    }
    
    public function includeCoupon(Order $model)
    {
        if (! $model->coupon) {
            return null;
        }
        return $this->item($model->coupon, new CouponTransformer());
    }
    
    public function includeItems(Order $model)
    {
        return $this->collection($model->items, new OrderItemTransformer());
    }
    
    public function includeClient(Order $model)
    {
        return $this->item($model->client, new ClientTransformer());
    }
    
    public function includeDeliveryman(Order $model)
    {
        return $this->item($model->deliveryman, new DeliverymanTransformer());
    }
}
