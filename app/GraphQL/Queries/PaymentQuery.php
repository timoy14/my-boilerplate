<?php

namespace App\GraphQL\Queries;
use App\Http\Controllers\Payments\PaymentController;

class PaymentQuery
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
    public function details($rootValue, array $args)
    {
        $PaymentController = new PaymentController();
        return $PaymentController->getChargeDetails($args["purchase_id"]);
    }
}
