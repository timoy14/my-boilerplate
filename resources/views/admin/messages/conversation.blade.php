@extends('layouts.admin')

@section('css')
<style>
    /* Chat chat-containers */
    .chat-container {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
    }

    /* Darker chat chat-container */
    .darker {
        border-color: #ccc;
        background-color: #ddd;
    }

    /* Clear floats */
    .chat-container::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Style images */
    .chat-container img {
        float: left;
        max-width: 60px;
        width: 100%;
        margin-right: 20px;
        border-radius: 50%;
    }

    /* Style the right image */
    .chat-container img.right {
        float: right;
        margin-left: 20px;
        margin-right: 0;
    }

    /* Style time text */
    .time-right {
        float: right;
        color: #aaa;
    }

    /* Style time text */
    .time-left {
        float: left;
        color: #999;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class='col-8'>
        <div class="row">
            <div class="col-md-4">
                <h3>{{ __('lang.order_details') }}</h3>
                <div class="card">
                    <div class="card-body">
                        <label class="control-label">
                            {{ __('lang.referrence_id') }} {{$purchase->referrence_id}}
                        </label>
                        <h2>{{$purchase->user->name}}</h2>
                        {{-- <button type="button" class="btn  btn-block btn-round  btn-info" data-dismiss="modal">
                            {{
                            __('lang.message') }}</button> --}}

                        {{-- <div class="conversation">
                            <a href="{{ route('messages.conversation',$purchase->id.'?message=customer' ) }}"
                                class="btn  btn-block btn-round  btn-info">

                                <div class="avatar">
                                    <span>
                                        {{$purchase->user->name}}
                                    </span>

                                    <img src="{{ $purchase->user->avatar ?? 'https://ph.bravo-care.com/images/defaults/logomarks.png' }}"
                                        style="width: 10%; height: 10%;">
                                </div>
                            </a>
                        </div> --}}
                        <div class="row">



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.email') }}
                                    </label>
                                    <input type="text" name="email" value="{{ $purchase->user->email }}"
                                        class="form-control" autocomplete="off" disabled>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.phone') }}
                                    </label>
                                    <input type="text" name="phone" value="{{ $purchase->user->phone }}"
                                        class="form-control" autocomplete="off" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($purchase->driver)
                <div class="card">
                    <div class="card-body">

                        <h2> {{ __('lang.driver') }}</h2>
                        <label class="control-label">
                            {{ __('lang.driver_id') }} {{$purchase->driver->id}}
                        </label>
                        <h2>{{$purchase->driver->name}}</h2>
                        {{--
                        <div class="conversation">
                            <a href="{{ route('messages.conversation',$purchase->id.'?message=driver') }}"
                                class="btn  btn-block btn-round  btn-info">



                                <div class="avatar">
                                    <span>
                                        {{$purchase->driver->name}}
                                    </span>

                                    <img src="{{ $purchase->driver->avatar ?? 'https://ph.bravo-care.com/images/defaults/logomarks.png' }}"
                                        style="width: 10%; height: 10%;">
                                </div>


                            </a>
                        </div> --}}
                        <div class="row">



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.email') }}
                                    </label>
                                    <input type="text" name="email" value="{{ $purchase->driver->email }}"
                                        class="form-control" autocomplete="off" disabled>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.phone') }}
                                    </label>
                                    <input type="text" name="phone" value="{{ $purchase->driver->phone }}"
                                        class="form-control" autocomplete="off" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.orders.update' , $purchase->id) }}" method="POST"
                            enctype="multipart/form-data" id="purchase-form-{{$purchase->id}}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <input type="hidden" name="return_type" value="{{url()->full()}}">

                            <div class="form-group">


                                <div class="table-responsive">
                                    <table id="home-table" class="table" style="  border: none;">

                                        <tbody>
                                            @foreach ($purchase->purchase_pharmacy_products as $item)
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

                                                @if ($purchase->status == "preparing_order" )


                                                <td style="border: none;">
                                                    <form class="d-initial warning"
                                                        action="{{ route('orders.purchases.update', $purchase->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="return_type"
                                                            value="{{url()->full()}}">

                                                        <input type="hidden" name="item_delete" value="{{ $item->id }}">
                                                        <button type="submit"
                                                            class="btn btn-danger pull-right btn-round">
                                                    </form> <i class="zmdi zmdi-delete"></i>

                                                    </button>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            {{-- <button type="button"
                                onclick="event.preventDefault(); document.getElementById('purchase-form-{{$purchase->id}}').submit();"
                                class="btn btn-primary pull-right btn-round">
                                {{ __('lang.update_to_preparing') }} <i class="fa fa-plus"></i>
                            </button> --}}
                        </form>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.tax_amount') }} ({{ $purchase->tax_rate }}%)
                                        </label>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="control-label">
                                        {{ $purchase->tax_amount }} <span>SR</span>
                                    </h4>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.delivery_fee') }}
                                        </label>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="control-label">
                                        {{ $purchase->delivery_fee }} <span>SR</span>
                                    </h4>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.total_amount') }}
                                        </label>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h3 class="control-label">
                                        {{ $purchase->total_amount }} <span>SR</span>
                                    </h3>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.invoice') }} {{ __('lang.status') }}
                                        </label>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if ($purchase->payment_status == 'Captured' )
                                    <h5 class="caption">

                                        {{ __('lang.paid') }}
                                    </h5>
                                    @else
                                    <h5 class="caption">
                                        {{ __('lang.not_yet_paid') }}
                                    </h5>
                                    {{ $purchase->payment_status}}
                                    @endif


                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.orders') }} {{ __('lang.status') }}
                                        </label>
                                        <h4 class="control-label">
                                            {{ __('lang.'.$purchase->status) }}

                                        </h4>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    @if ( $purchase->status == "order_received" )
                                    <form class="d-initial warning"
                                        action="{{ route('orders.purchases.update', $purchase->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="return_type" value="{{url()->full()}}">

                                        <input type="hidden" name="status" value="preparing_order">
                                        <button type="submit" class="btn btn-primary pull-right btn-round">
                                            {{ __('lang.update_to_preparing') }}

                                        </button>
                                    </form>
                                    @elseif ( $purchase->status == "preparing_order" )

                                    <form class="d-initial warning"
                                        action="{{ route('orders.purchases.update', $purchase->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="return_type" value="{{url()->full()}}">

                                        <input type="hidden" name="status" value="order_prepared">
                                        <button type="submit" class="btn btn-primary pull-right btn-round">
                                            {{ __('lang.order_prepared_and_search_driver') }}

                                        </button>
                                    </form>
                                    @elseif ( $purchase->status == "driver_arrived_at_store" )

                                    <form class="d-initial warning"
                                        action="{{ route('orders.purchases.update', $purchase->id) }}" method="POST">
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
                @if ( $purchase->status == "order_received" || $purchase->status == "preparing_order")
                <form class="wbd-form" action="{{ route('orders.purchases.update', $purchase->id) }}" method="POST">
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
    <div class='col-4'>
        <div class="card">
            <div class="card-header text-uppercase text-primary">
                {{ __('messages.chat') }} - {{$type}}
            </div>

            <div id="chat-body" class="card-body overflow-auto" style="height:500px;">


            </div>
            <!-- <div class="card-footer">
                <div class="form-row">
                    <button id="send-message"
                        class="form-group btn btn-primary col-3 text-center">{{__('lang.send')}}</button> <input
                        class="form-group col-9" type="text" name="message" id="my-message">

                </div>

            </div> -->
        </div>
    </div>

</div>
@endsection

@section('script')

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.1.0/firebase-app.js";
        import { getDatabase, ref, get, child, push, set, onValue } from "https://www.gstatic.com/firebasejs/9.1.0/firebase-database.js";

        //DB CONFIG
        const config = {
            apiKey: "AIzaSyCRowQDMSWcICnb6zE5Y8k9lZ4piiuutQA",
            authDomain: "bravo-care.firebaseapp.com",
            databaseURL: "https://bravo-care-default-rtdb.firebaseio.com/",
            projectId: "bravo-care",
            storageBucket: "bravo-care.appspot.com",
            messagingSenderId: "253515001065",
            appId: "1:253515001065:web:9e3b82f455e474a78d5478",
            measurementId: "${config.measurementId}"
        };
        initializeApp(config);

        //ID of the request


        const id = {{ $conversation_id }};
        const owner_id = {{ $owner_id }};
        const customer_id = {{ $customer_id }};
        const customer_name = "{{ $customer_name }}";
        const owner_name = "{{ $owner_name }}";
        const owner_photo = "{{ $owner_photo }}";
        const customer_photo = "{{ $customer_photo }}";
        var owner_photo_url = new URL("https://ph.bravo-care.com/images/defaults/logomarks.png");
        var customer_photo_url = new URL("https://ph.bravo-care.com/images/defaults/logomarks.png");

if (owner_photo != '') {
    var owner_photo_url = '{{$owner_photo}}';
}
if (customer_photo != '') {
    var customer_photo_url = '{{$customer_photo}}';
}


        // url.toJSON(); // should return the URL as a string


        console.log(id + " ");
        const dbRef = ref(getDatabase());

        const _sortMessagesByDate = (messageList) => {
            return messageList.sort((a, b) => {
            return  moment(a.time) - moment(b.time);
            });
        };

        //SETsMESSAGE TO CHAT BODY
        const setMessage = (item) => {
            var body = document.getElementById('chat-body');

            var container = document.createElement('div');


            var image = document.createElement('img');



            var text = document.createElement('p');
            var textContent = document.createTextNode(item.message);
            text.appendChild(textContent);


            var time = document.createElement('span');
            time.setAttribute('class', 'time-right');

                var timeContent = document.createTextNode(item.time);


            time.appendChild(timeContent);

            if(item.sender){
                container.setAttribute('class', 'chat-container');
                time.setAttribute('class', 'time-right');
                image.setAttribute('src', owner_photo_url.toString());
                }
                else{
                    container.setAttribute('class', 'chat-container darker');
                    time.setAttribute('class', 'time-left');
                    image.setAttribute('class', 'right');
                    image.setAttribute('src', customer_photo_url.toString());
                }


            container.appendChild(image);
            container.appendChild(text);
            container.appendChild(time);

            body.appendChild(container);
            body.scrollTop = body.scrollHeight;
        }

        //INITIAL SETMESSAGES
        const setMessages = (messageList) => {
            console.log(messageList);
            messageList.forEach(function (arrayItem) {
                // var x = arrayItem.prop1 + 2;
                console.log(arrayItem);
                setMessage(arrayItem);

            });

        };

        const getMessages = async () => {

            let messagesList = [];

            const customerMessages = await get(child(dbRef, `conversation/${id}/${customer_id}/messages`)).then((snapshot) => {

                if (snapshot.exists()) {
                    return snapshot.val();
                    // console.log(snapshot.val());
                    // customer_message = snapshot.val();
                }
                return [];
            }).catch((error) => {
                console.error(error);
            });


            if (customerMessages) {
                messagesList = Object.values(customerMessages).map((m) => {
                    m.sender = 'customer';
                    m.name = customer_name;
                    return m;
                });
            }

            // console.log(customerMessages);

            const ownerMessages = await get(child(dbRef, `conversation/${id}/${owner_id}/messages`)).then((snapshot) => {

                if (snapshot.exists()) {
                    return snapshot.val();
                    console.log(snapshot.val());
                    // customer_message = snapshot.val();
                }
                return [];
            }).catch((error) => {
                console.error(error);
            });



            if (ownerMessages) {
                const otherMessages = Object.values(ownerMessages)
                    .filter((m) => m)
                    .map((m) => {
                        m.type = 'text';
                        m.sender = 'owner';
                        m.name = owner_name;
                        return m;
                    });

                if (otherMessages) {
                    messagesList = [...messagesList, ...otherMessages];
                }
            }

            console.log(messagesList);

            setMessages(_sortMessagesByDate(messagesList));
            // setInitialLoad(true);

        };
        getMessages();

        const customerRef = ref(getDatabase(), `conversation/${id}/${customer_id}/messages`);


        onValue(customerRef, (snapshot) => {
            const data = snapshot.val();

            const itemArr = Object.values(data);
            const item = itemArr[itemArr.length - 1];
            // console.log(item);
            setMessage(item);
        });

        const getDatetimeString = () => {
            var m = new Date();
            var dateString =
                m.getUTCFullYear() + "-" +
                ("0" + (m.getUTCMonth()+1)).slice(-2) + "-" +
                ("0" + m.getUTCDate()).slice(-2) + " " +
                ("0" + m.getUTCHours()).slice(-2) + ":" +
                ("0" + m.getUTCMinutes()).slice(-2) + ":" +
                ("0" + m.getUTCSeconds()).slice(-2);
            return dateString;
        }

        //SEND MESSAGES
        const sendMessage = (message) => {
            const db = getDatabase();
            const messageListRef = ref(db,`/conversation/${id}/${owner_id}/messages`);
            const newMessageRef = push(messageListRef);
            const messageObj = {
                id: 2,
                type: "text",
                message: message,
                sender : 'owner',
                time: getDatetimeString(),
            };




            messageObj.type = 2;
            set(newMessageRef, messageObj);
            setMessage(messageObj);
            window.location.reload();
        }

        const sendCustomerMessage = (message) => {

            const db = getDatabase();
            const messageListRef = ref(db, `conversation/${id}/${owner_id}/messages`);
            const newMessageRef = push(messageListRef);
            set(newMessageRef, {
                id: 1,
                type: "text",
                message: message,
                sender : 'owner',
                time: getDatetimeString(),
            });
            window.location.reload();
        }
        // sendCustomerMessage("Hoy 3");

        $( "#send-message" ).click(function() {
            var message = $("#my-message").val();
            $("#my-message").val("");
            // sendMessage(message);
            sendCustomerMessage(message);
            // alert(message);
            // getMessages();
        });

        // $( "#send-message" ).click(function() {
        //     var message = $("#my-message").val();
        //     $("#my-message").val("");
        //     // sendMessage(message);
        //     sendCustomerMessage(message);
        //     // alert(message);
        //     // getMessages();
        // });

</script>



@endsection