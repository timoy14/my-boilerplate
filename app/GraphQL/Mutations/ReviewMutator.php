<?php

namespace App\GraphQL\Mutations;

use App\Events\CustomerServiceEvent;
use App\Events\DriverServiceEvent;
use App\Model\Purchase;
use App\Model\Review;
use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ReviewMutator
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

    public function review($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $time_stamp = Carbon::now();

        $purchase = Purchase::find($args['purchase_id']);

        if ($purchase->status == "customer_order_received" && $purchase->user_id == Auth()->user()->id) {
            $purchase->status = "rated";

            $purchase->status_notes = $purchase->status_notes . "(" . $time_stamp . ")  customer rate transaction %%";

            $purchase->save();

        } else {
            return [
                'status' => true,
                'message' => "this status cant be change by user",
            ];

        }
        $review = new Review();
        $review->user_id = Auth()->user()->id;

        $review->purchase_id = isset($args['purchase_id']) ? $args['purchase_id'] : null;
        $review->driver_id = isset($args['driver_id']) ? $args['driver_id'] : null;
        $review->pharmacy_id = isset($args['pharmacy_id']) ? $args['pharmacy_id'] : null;
        $review->star_driver = isset($args['star_driver']) ? $args['star_driver'] : null;
        $review->star_pharmacy = isset($args['star_pharmacy']) ? $args['star_pharmacy'] : null;
        $review->comment = isset($args['comment']) ? $args['comment'] : null;
        $review->display = isset($args['display']) ? $args['display'] : 0;
        $review->save();
        event(new CustomerServiceEvent($purchase, 'review'));
        event(new DriverServiceEvent($purchase, 'review'));
        return [
            'id' => $review->id,
            'status' => true,
            'message' => 'SUCCESS',
        ];

    }
}