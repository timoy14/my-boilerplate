<?php

namespace App\GraphQL\Mutations;

use App\Model\Cart;
use App\Model\CartPharmacyProduct;
use App\Model\PharmacyProduct;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CartMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function updateCart($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $pharmacy_product = PharmacyProduct::find($args['pharmacy_product_id']);

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth()->user()->id, 'pharmacy_id' => $pharmacy_product->user_id],

        );

        $cart_pharmacy_product = CartPharmacyProduct::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'pharmacy_product_id' => $args['pharmacy_product_id'],
                'pharmacy_product_variation_id' => $args['pharmacy_product_variation_id'],
            ],
            ['quantity' => $args['quantity']]
        );

        return [
            'status' => true,
            'message' => 'SUCCESS',
            'id' => $cart->id,
        ];

    }
    public function addCart($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $pharmacy_product = PharmacyProduct::find($args['pharmacy_product_id']);

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth()->user()->id, 'pharmacy_id' => $pharmacy_product->user_id],

        );

        $cart_pharmacy_product = CartPharmacyProduct::firstOrNew(
            [
                'cart_id' => $cart->id,
                'pharmacy_product_id' => $args['pharmacy_product_id'],
                'pharmacy_product_variation_id' => $args['pharmacy_product_variation_id'],
            ],

        );
        $cart_pharmacy_product->quantity = $args['quantity'] + $cart_pharmacy_product->quantity;
        $cart_pharmacy_product->save();
        return [
            'status' => true,
            'message' => 'SUCCESS',
            'id' => $cart->id,
        ];

    }
    public function deleteCart($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $cart_pharmacy_product = CartPharmacyProduct::find($args['cart_pharmacy_product_id']);
        $cart_pharmacy_product->delete();
        $cart = Cart::find($cart_pharmacy_product->cart_id)->cart_pharmacy_products()->exists();
        $id = $cart_pharmacy_product->cart_id;
        if (!$cart) {
            $cart = Cart::destroy($cart_pharmacy_product->cart_id);

        }

        return [
            'status' => true,
            'message' => 'SUCCESS',
            'id' => $id,
        ];
    }
}