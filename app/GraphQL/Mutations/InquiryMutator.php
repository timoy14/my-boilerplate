<?php

namespace App\GraphQL\Mutations;

use App\Model\Inquiry;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class InquiryMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function storeInquiery($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $address = new Inquiry();
        if (isset($args['user_id'])) {
            $address->user_id = $args['user_id'];
        }
        $address->name = $args['name'];
        $address->email = $args['email'];
        $address->type = "mobile";
        $address->message = $args['message'];

        $address->save();
        return [
            'status' => true,
            'message' => 'SUCCESS',
        ];

    }
}