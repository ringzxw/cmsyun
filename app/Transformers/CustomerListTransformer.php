<?php

namespace App\Transformers;

use App\Models\Customer;
use League\Fractal\TransformerAbstract;

class CustomerListTransformer extends TransformerAbstract
{
    public function transform(Customer $customer)
    {
        return [
            'id'            => $customer->id,
            'name'          => $customer->name,
        ];
    }
}