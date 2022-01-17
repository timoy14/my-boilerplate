<a onclick="clickModalorder({{$order->id}})"
    class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-success text-white" type="button"
    title=" branch : {{$order->id}}">{{ __('lang.view') }}</a>



<div class="modal fade" id="order-modal-{{$order->id}}" role="dialog" onclick="event.stopPropagation(); ">
    <div class="modal-dialog modal-lg" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">


                <h2 class="modal-title">{{$order->refference_id}}</h2> <button type="button" class="close"
                    data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">





                <div class="row">
                    <div class="col-md-4">
                        <h3>{{ __('lang.order_details') }}</h3>
                        <div class="card">
                            <div class="card-body">
                                <label class="control-label">
                                    {{ __('lang.referrence_id') }} {{$order->referrence_id}}
                                </label>
                                <h2>{{$order->user->name}}</h2>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ __('lang.email') }}
                                            </label>
                                            <input type="text" name="email" value="{{ $order->user->email }}"
                                                class="form-control" autocomplete="off" disabled>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ __('lang.phone') }}
                                            </label>
                                            <input type="text" name="phone" value="{{ $order->user->phone }}"
                                                class="form-control" autocomplete="off" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.orders.update' , $order->id) }}" method="POST"
                                    enctype="multipart/form-data" id="order-form-{{$order->id}}">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="return_type" value="{{url()->full()}}">

                                    <div class="form-group">


                                        <div class="table-responsive">
                                            <table id="home-table" class="table" style="  border: none;">

                                                <tbody>
                                                    @if(isset($order->order_pharmacy_products))
                                                        @foreach ($order->order_pharmacy_products as $item)
                                                            <tr>
                                                                <td style="border: none;">
                                                                    <strong>
                                                                        {{ (session()->get('locale') ===
                                                                        'ar') ? $item->ar :
                                                                        $item->en }}
                                                                    </strong>
                                                                </td style="border: none;">

                                                                <td style="border: none;"> <strong>{{ $item->quantity}} x {{
                                                                        $item->price}} SR </strong></td>


                                                                <td style="border: none;">{{ $item->total_amount }} SR</td>
                                                                @if ($order->status == "preparing_order" )


                                                                <td style="border: none;">
                                                                    <form class="d-initial warning"
                                                                        action="{{ route('admin.orders.update', $order->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="return_type"
                                                                            value="{{url()->full()}}">

                                                                        <input type="hidden" name="item_delete"
                                                                            value="{{ $item->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-danger pull-right btn-round">
                                                                    </form> <i class="zmdi zmdi-delete"></i>

                                                                    </button>
                                                                </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    {{-- <button type="button"
                                        onclick="event.preventDefault(); document.getElementById('order-form-{{$order->id}}').submit();"
                                        class="btn btn-primary pull-right btn-round">
                                        {{ __('lang.update_to_preparing') }} <i class="fa fa-plus"></i>
                                    </button> --}}
                                </form>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.total_amount') }}
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h2 class="control-label">
                                                {{ $order->total_amount }}
                                            </h2>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.invoice') }}
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @if ($order->payment_id == null )
                                            <h5 class="caption">
                                                {{ __('lang.not_yet_paid') }}
                                            </h5>
                                            @else
                                            <h5 class="caption">
                                                {{ __('lang.paid') }}
                                            </h5>
                                            @endif


                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.status') }}
                                                </label>
                                                <h4 class="control-label">
                                                    {{ $order->status }}
                                                </h4>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            @if ( $order->status == "order_received" )
                                            <form class="d-initial warning"
                                                action="{{ route('admin.orders.update', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="return_type" value="{{url()->full()}}">

                                                <input type="hidden" name="status" value="preparing_order">
                                                <button type="submit" class="btn btn-primary pull-right btn-round">
                                                    {{ __('lang.update_to_preparing') }}

                                                </button>
                                            </form>
                                            @elseif ( $order->status == "preparing_order" )

                                            <form class="d-initial warning"
                                                action="{{ route('admin.orders.update', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="return_type" value="{{url()->full()}}">

                                                <input type="hidden" name="status" value="order_prepared">
                                                <button type="submit" class="btn btn-primary pull-right btn-round">
                                                    {{ __('lang.order_prepared_and_search_driver') }}

                                                </button>
                                            </form>
                                            @elseif ( $order->status == "driver_arrived_at_store" )

                                            <form class="d-initial warning"
                                                action="{{ route('admin.orders.update', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="return_type" value="{{url()->full()}}">

                                                <input type="hidden" name="status" value="in_transit">
                                                <button type="submit" class="btn btn-primary pull-right btn-round">
                                                    {{ __('lang.driver_recived_the_order_and_in_transit') }}

                                                </button>
                                            </form>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                @if ( $order->status == "order_received" || $order->status == "preparing_order")
                <form class="wbd-form" action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="return_type" value="{{url()->full()}}">

                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-danger pull-right btn-round">
                        {{ __('lang.cancel_this_order') }}

                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
