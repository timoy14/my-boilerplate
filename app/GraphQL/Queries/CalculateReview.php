<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use App\Model\Review;

class CalculateReview
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

        $reviews = Review::where('property_id', $args['property_id']);
        $total = $reviews->count();
        $average = round(($total / 4),1);
        $count['one'] = Review::where('property_id', $args['property_id'])->where('star', 1)->count();
        $count['two'] = Review::where('property_id', $args['property_id'])->where('star', 2)->count();
        $count['three'] = Review::where('property_id', $args['property_id'])->where('star', 3)->count();
        $count['four'] = Review::where('property_id', $args['property_id'])->where('star', 4)->count();
        return [
            'total' => $total,
            'average' => $average,
            'count' => $count
        ];

    }
}
