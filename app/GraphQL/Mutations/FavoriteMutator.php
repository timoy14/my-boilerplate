<?php

namespace App\GraphQL\Mutations;

use App\Model\Service;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class FavoriteMutator
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
    public function service($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $service = Service::find($args['service_id']);

        if ($service) {
            if (Auth()->user()->favorites()->newPivotStatementForId($service->id)->exists()) {
                Auth()->user()->favorites()->detach($service);
                return [
                    'status' => true,
                    'message' => 'UNLIKE',
                ];
            } else {
                Auth()->user()->favorites()->attach($service);
                return [
                    'status' => true,
                    'message' => 'LIKE',
                ];
            }
        } else {
            throw new GraphqlException(
                'There is no service with that ID',
                'Please contact administrator'
            );
        }

    }
    public function section($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $section = Section::find($args['section_id']);

        if ($section) {
            if (Auth()->user()->section_favorites()->newPivotStatementForId($section->id)->exists()) {
                Auth()->user()->section_favorites()->detach($section);
                return [
                    'status' => true,
                    'message' => 'UNLIKE',
                ];
            } else {
                Auth()->user()->section_favorites()->attach($section);
                return [
                    'status' => true,
                    'message' => 'LIKE',
                ];
            }
        } else {
            throw new GraphqlException(
                trans('lang.there_is_no_section_with_that_id'),
                trans('lang.please_contact_administrator')
            );
        }
    }
}