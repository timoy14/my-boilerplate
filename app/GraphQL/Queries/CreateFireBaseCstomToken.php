<?php

namespace App\GraphQL\Queries;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseCustomToken;

class CreateFireBaseCstomToken
{

    public function __invoke($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $FirebaseCustomToken = new FirebaseCustomToken();
        $user_id = Auth::id();
        if($user_id){
            return ["token"=> $FirebaseCustomToken->create_custom_token($user_id)];
        }

        return ["token"=>null];
    }
    

}