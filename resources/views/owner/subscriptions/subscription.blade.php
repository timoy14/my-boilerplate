@extends('layouts.admin')

@section('css')
<style type="text/css">
    .checklist-ul {
        list-style-type: none;
        padding: 0;


    }

    .checklist-ul>li {
        padding: 0 0 0 25px;
        position: relative;
        margin-bottom: 5px;


    }

    .checklist-ul>li:before {
        position: absolute;
        left: 5px;
        content: "\2713";
        color: #666;
    }
</style>
@endsection

@section('content')
@include('partials._navbar')



<h2 id="title">Pricing table</h2>


<div class="hover-table-layout">
    @foreach ($subscriptions as $subscription)

    <div class="listing-item" style="margin: 20px">

        <figure class="image">
            <img src="https://i.ytimg.com/vi/MTrzTABzLfY/maxresdefault.jpg" alt="image">
            <figcaption>
                <div class="caption">
                    <h1> SAR <strong>{{$subscription->price}}</strong></h1>
                    <p>{{$subscription->name}}</p>
                </div>
            </figcaption>
        </figure>
        <div class="listing">
            <h4>{{$subscription->branch_count}} branches</h4>
            <h4>{{$subscription->advertisement_limit}} advertisements</h4>
            <h4>{{$subscription->offer_limit}} offers</h4>
            <h4>{{$subscription->employee_limit}} employees</h4>
            <h4>{{$subscription->duration}} duration</h4>
            <a class="btn btn-inverse-primary btn-block"
                href="{{ route('owner-subscriptions.subscriptions.subscribe', $subscription->id ) }}">select
                plan</a>
            <ul class="checklist-ul">
                @foreach ( json_decode($subscription->description) as $sub)

                @if (!empty($sub))
                <li>
                    {{$sub}}
                </li>
                @endif

                @endforeach
            </ul>

        </div>

    </div>

    @endforeach
</div>
@if (Auth::user()->isSubscribe())
<a href="{{ route('owner-subscriptions.subscriptions.index') }}" class="btn btn-inverse-primary float-right">
    {{ __('lang.back') }}
</a>
@endif




@endsection

@section('script')

<script>
    $(document).ready(function() {
         function listing_select(id){
             console.log('subscription');
            // window.location.href = '/list/subscription/'+1;
        }
    })
</script>
@endsection
