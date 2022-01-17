<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Exceptions\GraphqlException;

use Illuminate\Support\Facades\Auth;
use App\Model\Conversation;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use App\User;
use Uuid;


class CheckConversationID
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
        $receiver = User::find($args['receiver_id']);

        if ($receiver) 
        {
            $conversation_id = strtoupper(Uuid::generate()->string);

            $first = Conversation::where('creator_id',Auth()->user()->id)->where('receiver_id', $args['receiver_id'])->first();
            if ($first) 
            {
                $conversation_id = $first->conversation_id;
            }

            $second = Conversation::where('creator_id',$args['receiver_id'])->where('receiver_id', Auth()->user()->id)->first();
            if ($second) 
            {
                $conversation_id = $second->conversation_id;
            }

            if (!$first && !$second) 
            {
                $conversation =  new Conversation();
                $conversation->conversation_id =  $conversation_id;
                $conversation->creator_id =  Auth()->user()->id;
                $conversation->receiver_id =  $args['receiver_id'];
                $conversation->save();

                // Add Conversation ID Firebase
            }

            return $conversation_id;

        }else{
            throw new GraphqlException(
                'Receiver Not Found',
                'Please contact administrator'
            );
        }
    }
}
