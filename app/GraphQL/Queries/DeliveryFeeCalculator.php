<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use App\Model\Setting;

class DeliveryFeeCalculator
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $delivery_fee = 5;
        $distance = $args["distance"];
        $Setting = Setting::find(1);
        
        if ($distance < 5) {
            $delivery_fee = $Setting->delivery_fee_less_than_5_km;
        }elseif ($distance >= 5 && $distance <= 10) {
            $delivery_fee = $Setting->delivery_fee_5_to_10_km;
        }elseif ($distance > 10) {
            $delivery_fee = $Setting->delivery_fee_more_than_10_km;
        }

        return [
            "delivery_fee" => $delivery_fee
        ];

    }
}
