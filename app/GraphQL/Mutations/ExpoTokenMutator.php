<?php

namespace App\GraphQL\Mutations;

use App\Model\Token;
use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ExpoTokenMutator
{

    public function addExpoToken($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        // Set Null pag naa cya makita same og token.
        $users = User::where('id', '<>', Auth()->user()->id)
            ->where('exponent_token', $args['token'])->update(['exponent_token' => null]);

        $user = Auth()->user();
        $user->exponent_token = $args['token'];
        $user->save();

        $AuthToken = $_SERVER['HTTP_AUTHORIZATION'];
        $AuthToken = substr($AuthToken, 7);

        $token = Token::where('api_token', $AuthToken)->where('user_id', $user->id)->update(['firebase_token' => $args['token']]);

        return [
            'status' => true,
            'message' => 'SUCCESS',
        ];
    }

    public function removeExpoToken($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $user = Auth()->user();
        $user->exponent_token = null;
        $user->save();
        $AuthToken = $_SERVER['HTTP_AUTHORIZATION'];
        $AuthToken = substr($AuthToken, 7);
        $token = Token::where('api_token', $AuthToken)->where('user_id', $user->id)->update(['firebase_token' => null]);

        return [
            'status' => true,
            'message' => 'SUCCESS',
        ];
    }
}