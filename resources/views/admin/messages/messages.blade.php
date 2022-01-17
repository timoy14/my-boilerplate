{{-- @extends('voyager::master') --}}
@extends('layouts.admin')
@section('page_title', 'Conversations')

@section('content')
<div class="page-content container-fluid">
    <div class="panel panel-bordered all-messages">
        <div class="panel-body">
            <div class="chat">
                <h3>
                    {{ __('lang.messages') }}


                </h3>
                <div id="coversations" style="height:500px;">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script type="module">
    // import { moment } from "";

        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.1.0/firebase-app.js";
        import {
            getDatabase,
            ref,
            get,
            child,
            push,
            set,
            onValue,
            serverTimestamp
        } from "https://www.gstatic.com/firebasejs/9.1.0/firebase-database.js";
        import {
            getFirestore
        } from "https://www.gstatic.com/firebasejs/9.1.0/firebase-firestore.js";

        const admin_id = 1;
        const config = {
            apiKey: "AIzaSyCRowQDMSWcICnb6zE5Y8k9lZ4piiuutQA",
            authDomain: "bravo-care.firebaseapp.com",
            databaseURL: "https://bravo-care-default-rtdb.firebaseio.com/",
            projectId: "bravo-care",
            storageBucket: "bravo-care.appspot.com",
            messagingSenderId: "253515001065",
            appId: "1:253515001065:web:9e3b82f455e474a78d5478",
            measurementId: "G-JN59H0J4Z6"
        };
        const firebaseApp = initializeApp(config);
        const firestore = getFirestore(firebaseApp);
        const dbRef = ref(getDatabase());

        const _sortMessagesByDate = (messageList) => {

            return messageList.sort((a, b) => {
                return moment(a.time) - moment(b.time);
            });
        };

        const all_messages = await get(child(dbRef, `conversation`)).then((snapshot) => {
            if (snapshot.exists()) {
                return snapshot.val();
            }
            return [];
        }).catch((error) => {
            console.log(error);
        });

        const orders = JSON.parse('{!! $orders !!}');

        let conversations = [];
        for (const [key, value] of Object.entries(all_messages)) {
            let msgs = [];


            const otherMessages = Object.values(value)
                .filter((m) => m)
                .map((m) => {
                    if (m.messages) {
                        for (const [k, v] of Object.entries(m.messages)) {
                            if (v && v.time)
                                msgs.push(v);
                        }
                    }
                });
            if (msgs.length == 0) {
                continue;
            }
            const sorted_messages = _sortMessagesByDate(msgs);
            conversations.push({
                id: key,
                time: sorted_messages[sorted_messages.length - 1].time,
                lastmessage: sorted_messages[sorted_messages.length - 1].message
            });
        }

        const sorted_conversation = _sortMessagesByDate(conversations).reverse();

        function isValidHttpUrl(string) {
            let url;

            try {
                url = new URL(string);
            } catch (_) {
                return false;
            }

            return url.protocol === "http:" || url.protocol === "https:";
        }

        sorted_conversation.forEach((conversation) => {

            var user = {};
            for (var key in conversation) {
                if (conversation.hasOwnProperty(key) && key != admin_id) {
                    user = conversation[key];
                }
            }

            const order = orders.find((o) => {
                return o.id == parseInt(conversation.id)
            });
            const default_avatar = 'https://ph.bravo-care.com/images/defaults/logomarks.png';

            if (order)
                $("#coversations").append(
                    `<div class="conversation">
                        <a href="messages/${conversation.id}">

                            <div class="avatar">
                                <img src="${order.avatar ?? default_avatar }">
                            </div>
                            <div class="details">
                                <div class="user">${order.name} - ${moment(conversation.time).format('lll')}</div>
                                <div class="message">
                                    ${isValidHttpUrl(conversation.lastmessage)  ? "{{ __('dashboard.image_sent')}}" : conversation.message}
                                </div>
                            </div>

                        </a>
                    </div>`
                );

        });
</script>



@endsection
