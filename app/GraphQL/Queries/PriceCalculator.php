<?php

namespace App\GraphQL\Queries;

use App\Model\Booking;
use App\Model\Service;
use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class PriceCalculator
{

    public $generalPrice = null;
    public $todayDate = null;

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
        $booking = Booking::find($args['booking_id']);
        $this->todayDate = Carbon::today();

        // TODO implement the resolver
        $service = Service::find($args['property_id']);

        // Set service general price first; treat them as private always. if they have section_id. other parameter
        $this->generalPrice = $service->general_price;

        // If commercial, It needs to have a section id
        if ($service->category->id == 1 && !isset($args['section_id'])) {
            throw new GraphqlException(
                'Please provide me a section, since its a commercial service',
                'Please contact administrator'
            );
        }
        if ($service->category->id == 3 && $service->trips_individual == 0 && !isset($args['section_id'])) {

            return [
                'status' => false,
                'message' => "Please provide me a section, since its a trips company service",
            ];
        }
        // Check if the section id is co
        if (isset($args['section_id'])) {
            $section = $service->sections->find($args['section_id']);
            if (!$section) {
                throw new GraphqlException(
                    'Service doesnt have this section',
                    'Your section doesnt belong to your service '
                );
            }
            $this->generalPrice = $section->general_price;
        }

        // Check if check in is past.
        if (Carbon::parse($args['check_in']) < $this->todayDate) {
            throw new GraphqlException(
                'Please check in date is already past',
                'Please contact administrator'
            );
        }

        // Check if check out is past.
        if (Carbon::parse($args['check_out']) < $this->todayDate) {
            throw new GraphqlException(
                'Please check out date is already past',
                'Please contact administrator'
            );
        }

        // Check if check out date is above the check in date
        if (Carbon::parse($args['check_in']) > Carbon::parse($args['check_out'])) {
            throw new GraphqlException(
                'Please check date range if its valid one',
                'Please contact administrator'
            );
        }

        // Check if check in date is equal to check out date
        if (Carbon::parse($args['check_in']) == Carbon::parse($args['check_out'])) {
            throw new GraphqlException(
                'The check in and check out must not be equal',
                'Please contact administrator'
            );
        }

        $diffDays = Carbon::parse($args['check_in'])->diffInDays(Carbon::parse($args['check_out']));
        $details = $this->getDetails($args['check_in'], $args['check_out']);

        return [
            'total_price' => $details['total'],
            'diff_days' => $diffDays,
            'details' => $details['lists'],
        ];
    }

    public function getDetails($check_in, $check_out)
    {
        $total = 0;
        $return = array();
        $dates = $this->getDatesFromRange($check_in, $check_out);

        foreach ($dates as $date) {
            $list = array();
            $list['date'] = Carbon::parse($date)->format('l');
            $list['price'] = $this->getGeneralPrice($date);
            $total += $list['price'];
            $list['seasonal'] = false;
            $list['available'] = true;
            $return['lists'][] = $list;
        }

        $return['total'] = $total;
        return $return;
    }

    public function getDatesFromRange($start, $end)
    {
        $dates = array($start);
        while (end($dates) < $end) {
            $dates[] = date('Y-m-d', strtotime(end($dates) . ' +1 day'));
        }
        // Remove the last dates.
        array_pop($dates);

        return $dates;
    }

    public function getGeneralPrice($date)
    {

        switch (Carbon::parse($date)->format('l')) {
            case 'Sunday':
                return $this->generalPrice->sunday;
                break;

            case 'Saturday':
                return $this->generalPrice->saturday;
                break;

            case 'Friday':
                return $this->generalPrice->friday;
                break;

            case 'Thursday':
                return $this->generalPrice->thursday;
                break;

            case 'Wednesday':
                return $this->generalPrice->wednesday;
                break;

            case 'Tuesday':
                return $this->generalPrice->tuesday;
                break;

            case 'Monday':
                return $this->generalPrice->monday;
                break;

            default:
                return 0;
                break;
        }
    }

}