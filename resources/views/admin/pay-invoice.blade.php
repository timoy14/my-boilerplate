@extends('layouts.payment')

@section('content')
<form
    action="{{URL::to('/')}}/return-url?redirect_link{{urlencode($data['redirect_link'])}}payment_reference={{$data['response']['id']}}&booking_id={{urlencode($data['booking_id'])}}&brand={{urlencode($data['brand'])}}&type={{urlencode($data['type'])}}&commission_rate={{urlencode($data['commission_rate'])}}&tax={{urlencode($data['tax'])}}&amount={{urlencode($data['amount'])}}&discount_id={{urlencode($data['discount_id'])}}&merchantTransactionId={{urlencode($data['merchantTransactionId'])}}"
    class=" paymentWidgets" data-brands=" {{$data['brand']}}"></form>

@endsection

@push('foot')

<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$data['response']['id']}}"></script>
@if($data['brand'] == 'APPLEPAY')
<script>
    var wpwlOptions= {
      applePay : {
        displayName: "alrapeh",
        total: { label: "alrapeh items" },
        merchantCapabilities:["supports3DS"],
        supportedNetworks: ["masterCard", "visa", "mada"],
      }
    }
</script>
@endif
@endpush
