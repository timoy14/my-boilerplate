<?php

namespace App\GraphQL\Queries;

use App\Model\Advertisement;
use App\Model\Booking;
use App\Model\Branch;
use App\Model\City;
use App\Model\PharmacyProduct;
use App\Model\Purchase;
use App\Model\Service;
use App\User;
use Carbon\Carbon;
use DB;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

// use App\Exceptions\GraphqlException
class Filter
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

    public function getCitiesWithPharmacy($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $cities = City::query();

        $cities->whereHas('users', function ($query) {
            $query->where('role_id', 3);
        });
        return $cities;
    }

    public function getNearbyPharmacy($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $pharmacists = User::query();
        $pharmacists = $pharmacists->where('role_id', 3)->where('registration_status', 'accepted');
        if (isset($args['city_id'])) {
            $pharmacists = $pharmacists->where('city_id', $args['city_id']);
        }
        if (isset($args['search'])) {
            $pharmacists = $pharmacists->whereHas('city', function ($query1) use ($args) {
                $query1->where('en', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('en_1', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('ar', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('ar_1', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('ar_2', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('ar_3', 'LIKE', '%' . $args['search'] . '%');
            })->orWhere('address', 'LIKE', '%' . $args['search'] . '%');

        }

        if (isset($args['latitude']) && isset($args['longitude'])) {
            $latitude = $args['latitude'];
            $longitude = $args['longitude'];
            $pharmacists = $pharmacists->addSelect(DB::raw("*,
            (6373000 * ACOS(COS(RADIANS($latitude))
              * COS(RADIANS(latitude))
             * COS(RADIANS($longitude) - RADIANS(longitude))
              + SIN(RADIANS($latitude))
              * SIN(RADIANS(latitude)))) AS distance"))
                ->whereRaw('
        (6373000 * ACOS(COS(RADIANS(?))
          * COS(RADIANS(latitude))
         * COS(RADIANS(?) - RADIANS(longitude))
          + SIN(RADIANS(?))
          * SIN(RADIANS(latitude)))) <= ?', [$latitude, $longitude, $latitude, 5000])
                ->orderBy('distance', 'ASC');
        }

        return $pharmacists;
    }

    public function searchProductByCategory($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $products = PharmacyProduct::query();

        $products->whereHas('user', function ($query) {
            $query->where('registration_status', 'accepted');
        })->whereHas('pharmacy_product_variations');

        if (isset($args['product_category_id'])) {
            $products->where('product_category_id', $args['product_category_id']);
        }

        if (isset($args['latitude']) && isset($args['longitude'])) {

            $latitude = $args['latitude'];
            $longitude = $args['longitude'];

            $products->whereHas('users', function ($query) use ($latitude, $longitude) {
                $query->where('role_id', 3)->addSelect(DB::raw("*,
                (6373000 * ACOS(COS(RADIANS($latitude))
                  * COS(RADIANS(latitude))
                 * COS(RADIANS($longitude) - RADIANS(longitude))
                  + SIN(RADIANS($latitude))
                  * SIN(RADIANS(latitude)))) AS distance"))
                    ->whereRaw('
            (6373000 * ACOS(COS(RADIANS(?))
              * COS(RADIANS(latitude))
             * COS(RADIANS(?) - RADIANS(longitude))
              + SIN(RADIANS(?))
              * SIN(RADIANS(latitude)))) <= ?', [$latitude, $longitude, $latitude, 5000])
                    ->orderBy('distance', 'ASC');
            });
        }
        if (isset($args['search'])) {
            $products->whereHas('product', function ($query1) use ($args) {
                $query1->where('scientific_name', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('scientific_name_arabic', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('trade_name', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('trade_name_arabic', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('register_number', 'LIKE', '%' . $args['search'] . '%');
            });
        }
        return $products;
    }

    public function searchProduct($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $products = PharmacyProduct::query();
        $products->whereHas('user', function ($query) {
            $query->where('registration_status', 'accepted');
        })->whereHas('pharmacy_product_variations');
        if (isset($args['pharmacy_id'])) {
            $products->where('user_id', $args['pharmacy_id']);
        }
        if (isset($args['latitude']) && isset($args['longitude'])) {

            $latitude = $args['latitude'];
            $longitude = $args['longitude'];

            $products->whereHas('user', function ($query) use ($latitude, $longitude) {
                $query->where('role_id', 3)->addSelect(DB::raw("*,
                (6373000 * ACOS(COS(RADIANS($latitude))
                  * COS(RADIANS(latitude))
                 * COS(RADIANS($longitude) - RADIANS(longitude))
                  + SIN(RADIANS($latitude))
                  * SIN(RADIANS(latitude)))) AS distance"))
                    ->whereRaw('
            (6373000 * ACOS(COS(RADIANS(?))
              * COS(RADIANS(latitude))
             * COS(RADIANS(?) - RADIANS(longitude))
              + SIN(RADIANS(?))
              * SIN(RADIANS(latitude)))) <= ?', [$latitude, $longitude, $latitude, 5000])
                    ->orderBy('distance', 'ASC');
            });
        }
        if (isset($args['search'])) {
            $products->whereHas('product', function ($query1) use ($args) {
                $query1->where('scientific_name', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('scientific_name_arabic', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('trade_name', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('trade_name_arabic', 'LIKE', '%' . $args['search'] . '%')
                    ->orWhere('register_number', 'LIKE', '%' . $args['search'] . '%');
            });
        }
        return $products;
    }

    public function searchPharmacy($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $pharmacists = User::query();
        $pharmacists = $pharmacists->where('role_id', 3)->where('registration_status', 'accepted');
        if (isset($args['city_id'])) {
            $pharmacists = $pharmacists->where('city_id', $args['city_id']);
        }
        if (isset($args['search'])) {
            $pharmacists
                ->WhereHas('city', function ($query1) use ($args) {
                    $query1->where('en', 'LIKE', '%' . $args['search'] . '%')
                        ->orWhere('en_1', 'LIKE', '%' . $args['search'] . '%')
                        ->orWhere('ar', 'LIKE', '%' . $args['search'] . '%')
                        ->orWhere('ar_1', 'LIKE', '%' . $args['search'] . '%')
                        ->orWhere('ar_2', 'LIKE', '%' . $args['search'] . '%')
                        ->orWhere('ar_3', 'LIKE', '%' . $args['search'] . '%');
                })->orWhere('address', 'LIKE', '%' . $args['search'] . '%')
                ->orWhere('pharmacy_name', 'LIKE', '%' . $args['search'] . '%');
        }
        if (isset($args['latitude']) && isset($args['longitude'])) {
            $latitude = $args['latitude'];
            $longitude = $args['longitude'];
            $pharmacists = $pharmacists->addSelect(DB::raw("*,
            (6373000 * ACOS(COS(RADIANS($latitude))
              * COS(RADIANS(latitude))
             * COS(RADIANS($longitude) - RADIANS(longitude))
              + SIN(RADIANS($latitude))
              * SIN(RADIANS(latitude)))) AS distance"))
                ->whereRaw('
        (6373000 * ACOS(COS(RADIANS(?))
          * COS(RADIANS(latitude))
         * COS(RADIANS(?) - RADIANS(longitude))
          + SIN(RADIANS(?))
          * SIN(RADIANS(latitude)))) <= ?', [$latitude, $longitude, $latitude, 5000])
                ->orderBy('distance', 'ASC');
        }

        return $pharmacists;
    }
    public function getNearbyAvailableOrderToFetch($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $purchase = Purchase::query();
        $purchase->where('status', 'order_prepared');

        if (isset($args['latitude']) && isset($args['longitude'])) {

            $latitude = $args['latitude'];
            $longitude = $args['longitude'];

            $purchase = $purchase->addSelect(DB::raw("*,
            (6373000 * ACOS(COS(RADIANS($latitude))
              * COS(RADIANS(latitude))
             * COS(RADIANS($longitude) - RADIANS(longitude))
              + SIN(RADIANS($latitude))
              * SIN(RADIANS(latitude)))) AS distance"))
                ->whereRaw('
        (6373000 * ACOS(COS(RADIANS(?))
          * COS(RADIANS(latitude))
         * COS(RADIANS(?) - RADIANS(longitude))
          + SIN(RADIANS(?))
          * SIN(RADIANS(latitude)))) <= ?', [$latitude, $longitude, $latitude, 10000])
                ->orderBy('distance', 'ASC');
        }
        return $purchase;
    }

    public function riderDeliveries($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (isset($args['date_from']) && isset($args['date_to'])) {
            $date_start = $args['date_from'];
            $date_end = $args['date_to'];
        }

        $user_id = Auth()->user()->id;
        $purchases = Purchase::query();
        $purchases = $purchases->where('driver_id', $user_id)->whereIn('status', ['rated', 'customer_order_received', 'order_complete']);

        if ($args['method'] == "claimed") {
            $purchases = $purchases->whereNotNull('timestamp_claim_driver_commission');
        } elseif ($args['method'] == "unclaimed") {
            $purchases = $purchases->whereNull('timestamp_claim_driver_commission');

        }
        if (isset($args['date_from']) && isset($args['date_to'])) {
            $purchases = $purchases->whereBetween('created_at', [$date_start, $date_end]);
        }

        return $purchases;
    }

    public function CalculateDriverReportResponse($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $date_start = "";
        $date_end = "";
        $user_id = Auth()->user()->id;
        $purchases = Purchase::query();

        $purchases = $purchases->where('driver_id', $user_id)
            ->whereIn('status', ['rated', 'customer_order_received', 'order_complete'])
            ->orderBy('created_at');
        if ($args['method'] == "claimed") {
            $purchases = $purchases->whereNotNull('timestamp_claim_driver_commission');

        } elseif ($args['method'] == "unclaimed") {
            $purchases = $purchases->whereNull('timestamp_claim_driver_commission');

        }
        if (isset($args['date_from']) && isset($args['date_to'])) {
            $date_start = $args['date_from'];
            $date_end = $args['date_to'];
            $purchases = $purchases->whereBetween('created_at', [$date_start, $date_end]);

        }

        if ($purchases->get()->first()) {
            $date_start = $purchases->get()->first()->created_at;
        }
        if ($purchases->get()->last()) {
            $date_end = $purchases->get()->last()->created_at;
        }

        $count = $purchases->count();

        $total = $purchases->sum('driver_commission');
        $total_delivery_fee = $purchases->sum('delivery_fee');
        $total_bravo_commission = $total_delivery_fee - $total;

        return [
            'total_bravo_commission' => $total_bravo_commission,
            'total' => $total,
            'method' => $args['method'],
            'count' => $count,
            'date_start' => $date_start,
            'date_end' => $date_end,
        ];

    }
    public function CalculateDriverReportbyMonth($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $user_id = Auth()->user()->id;

        $purchases = Purchase::query();
        $data = [];
        $today = Carbon::now();

        $purchases = $purchases->where('driver_id', $user_id)
            ->orderBy('created_at');

        $year = $args['year'];
        $monthNum = $args['month'];
        $data["month"] = $monthNum;
        $data["year"] = $year;
        $data["count"] = $purchases->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->whereIn('status', ['rated', 'customer_order_received', 'order_complete'])->count();
        $total = $purchases->sum('driver_commission');
        $total_delivery_fee = $purchases->sum('delivery_fee');
        $total_bravo_commission = $total_delivery_fee - $total;
        $data["total"] = $total;
        $data["total_bravo_commission"] = $total_bravo_commission;

        return $data;

    }
    public function CalculateDriverReportbyMonths($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $user_id = Auth()->user()->id;

        $purchases = Purchase::query();
        $purchases = $purchases->where('driver_id', $user_id);
        $data = [];
        $today = Carbon::now();
        $date_start = '';
        $year = Carbon::parse($today)->format('Y');
        $month = Carbon::now()->subMonths(1);
        $purchases = $purchases->where('driver_id', $user_id)
            ->whereIn('status', ['rated', 'customer_order_received', 'order_complete'])
            ->orderBy('created_at');
        if ($purchases->get()->first()) {
            $date_start = $purchases->get()->first()->created_at;
        }

        if (isset($args['month_count'])) {
            $diff_in_months = $args['month_count'];
        } else {

            $date = Carbon::parse($date_start)->format('Y-m-d');
            $diff_in_months = $today->diffInMonths($date);
        }

        for ($i = 0; $i <= $diff_in_months; $i++) {

            $purchases = Purchase::query();
            $year = Carbon::now()->subMonths($i)->year;
            $monthNum = Carbon::now()->subMonths($i);
            $data[$i]["month"] = $monthNum->month;
            $data[$i]["year"] = $year;
            $data[$i]["count"] = $purchases->whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNum->month)
                ->whereIn('status', ['rated', 'customer_order_received', 'order_complete'])->count();
            $total = $purchases->sum('driver_commission');
            $total_delivery_fee = $purchases->sum('delivery_fee');
            $total_bravo_commission = $total_delivery_fee - $total;
            $data[$i]["total"] = $total;
            $data[$i]["total_bravo_commission"] = $total_bravo_commission;

            $data[$i]["date_start"] = $date_start;
            $data[$i]["date_end"] = $today;
            $data[$i]["method"] = $diff_in_months;
        }
        return $data;

    }

    public function byBookingStatus($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $bookings = Booking::query();
        $bookings->where('user_id', $args['user_id']);
        if (isset($args['status'])) {
            $bookings->where('status', $args['status']);
        }
        if (isset($args['current'])) {

            if ($args['current']) {
                $bookings->whereIn('status', ['pending', 'received', 'confirmed', 'ongoing']);
            } else {
                $bookings->whereIn('status', ['complete', 'cancel', 'rated']);
            }
        }
        return $bookings;
    }

    public function byCategoryAdvertisement($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $ads = Advertisement::query();
        if (isset($args['display'])) {
            $ads->where('display', $args['display']);
        }
        if (isset($args['category_id'])) {
            $ads->whereHas('service', function ($query1) use ($args) {
                $query1->whereHas('branch', function ($query2) use ($args) {
                    $query2->whereHas('user', function ($query3) use ($args) {
                        $query3->where('category_id', $args['category_id']);
                    });
                });
            });
        }
        return $ads;
    }

    public function branchFilter($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $whereGlobal = function ($query) use ($args) {
            if (isset($args['category_id'])) {

                $query->whereHas('user', function ($query1) use ($args) {
                    $query1->where('category_id', $args['category_id']);
                });
            }
            if (isset($args['subcategory_id'])) {

                $query->where('subcategory_id', $args['subcategory_id']);
            }

            if (isset($args['name'])) {
                $name = $args['name'];
                $query->where('name', 'LIKE', '%' . $name . '%')
                    ->orWhere('name_ar', 'LIKE', '%' . $name . '%')
                    ->orWhere('address', 'LIKE', '%' . $name . '%');

            }

        };

        if ($args['method'] == 'location' && isset($args['longitude']) && isset($args['latitude'])) {

            $latitude = $args['latitude'];
            $longitude = $args['longitude'];

            $branches = Branch::addSelect(DB::raw("*,
                (6373000 * ACOS(COS(RADIANS($latitude))
                  * COS(RADIANS(latitude))
                 * COS(RADIANS($longitude) - RADIANS(longitude))
                  + SIN(RADIANS($latitude))
                  * SIN(RADIANS(latitude)))) AS distance"))
                ->where($whereGlobal)
                ->whereRaw('
            (6373000 * ACOS(COS(RADIANS(?))
              * COS(RADIANS(latitude))
             * COS(RADIANS(?) - RADIANS(longitude))
              + SIN(RADIANS(?))
              * SIN(RADIANS(latitude)))) <= ?', [$latitude, $longitude, $latitude, 5000])
                ->orderBy('distance', 'ASC');

            return $branches;
        }
        if ($args['method'] == 'rating') {
            $branches = Branch::where($whereGlobal)->withCount(['reviews as average' => function ($que) {
                $que->select(DB::raw('coalesce(avg(star_service),0)'));
            }])->orderByDesc('average');

            return $branches;
        }
        if ($args['method'] == 'trending') {

            $branches = Branch::where($whereGlobal)->withCount('complete_bookings as count_booking')->orderByDesc('count_booking');

            return $branches;
        }

        return Branch::where($whereGlobal);

    }

    public function serviceFilter($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $whereGlobal = function ($query) use ($args) {

            if (isset($args['offer'])) {
                $query->where('offer', $args['offer']);
            }
            if (isset($args['name'])) {
                $name = $args['name'];
                $query->where('en', 'LIKE', '%' . $name . '%')->orWhere('ar', 'LIKE', '%' . $name . '%');
            }
            if (isset($args['category_id'])) {
                $query->whereHas('branch', function ($query) use ($args) {
                    $query->whereHas('user', function ($query) use ($args) {
                        $query->where('category_id', $args['category_id']);
                    });
                });
            }
            if (isset($args['branch_service_category'])) {

                $query->whereHas('branch_service_category', function ($query) use ($args) {
                    $branch_service_category = $args['branch_service_category'];
                    $query->where('en', 'LIKE', '%' . $branch_service_category . '%')->orWhere('ar', 'LIKE', '%' . $branch_service_category . '%');
                });
            }

        };

        if ($args['method'] == 'recommended') {
            $services = Service::where($whereGlobal)->where('offer', 1)->withCount(['reviews as average' => function ($que) {
                $que->select(DB::raw('coalesce(avg(star_service),0)'));
            }])->orderByDesc('average');

            return $services;
        }

        if ($args['method'] == 'trending') {

            $services = Service::where($whereGlobal)->where('offer', 1)->withCount('booking_services as count_booking')->orderByDesc('count_booking');

            return $services;

        }
        if ($args['method'] == 'latest') {

            $services = Service::where($whereGlobal)->where('offer', 1)->orderByDesc('offer_date_start');

            return $services;

        }

        return Service::where($whereGlobal);

    }

}