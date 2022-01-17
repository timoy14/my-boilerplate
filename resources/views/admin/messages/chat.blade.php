@extends('layouts.admin')
@section('page_title', $customer_name . ' Messages')

@section('content')
<div class="container-fluid">
    <div class="panel panel-bordered single-message">
        <div class="panel-body">
            <div class="chat">
                <h3>
                    {{ __('messages.chat') }} - {{ $customer_name }}
                </h3>
                <div id="chat-body" style="height:500px;">
                </div>

                <div class="message-box">
                    <input type="text" name="message" id="my-message">
                    <button id="send-message" class="btn btn-primary ">{{ __('messages.send') }}</button>
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
            update,
            onValue,
            serverTimestamp
        } from "https://www.gstatic.com/firebasejs/9.1.0/firebase-database.js";
        import {
            getFirestore
        } from "https://www.gstatic.com/firebasejs/9.1.0/firebase-firestore.js";

        //DB CONFIG
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

        const id = {{ $conversation_id }};
        const owner_id = {{ $owner_id }};
        const customer_id = {{ $customer_id }};
        const customer_name = "{{ $customer_name }}";
        const owner_name = "{{ $owner_name }}";


        const owner_photo_url = new URL("https://dummyimage.com/100x100/000/fff.png&text=U");
        const customer_photo_url = new URL("https://dummyimage.com/100x100/000/fff.png&text=U");


        const dbRef = ref(getDatabase());
        // console.log();
        const _sortMessagesByDate = (messageList) => {
            return messageList.sort((a, b) => {
                return moment(a.time) - moment(b.time);
            });
        };

        //SETsMESSAGE TO CHAT BODY
        const setMessage = (item) => {
            console.log(item)
            var body = document.getElementById('chat-body');
            var container = document.createElement('div');
            var image = document.createElement('img');
            var name = document.createElement('p');
            var nameContent = document.createTextNode(item.name ?? "Anon");
            var msgContainer = document.createElement('div');
            name.setAttribute('class', 'message-owner');
            var text = document.createElement('p');

            if (item.type == 'image') {
                var textContent = document.createElement('img');
                textContent.src = item.message;

            } else {
                var textContent = document.createTextNode(item.message);

            }
            text.appendChild(textContent);
            var time = document.createElement('span');
            time.setAttribute('class', 'time-right');
            var timeContent = document.createTextNode(moment(item.time).format('llll'));

            time.appendChild(timeContent);
            msgContainer.appendChild(name);
            name.appendChild(nameContent);
            name.appendChild(time);
            msgContainer.appendChild(text);
            msgContainer.setAttribute('class', 'msg-details');

            // console.log(item.type)
            if (item.sender == 'customer') {
                container.setAttribute('class', 'chat-container');
                time.setAttribute('class', 'time-right');
                image.setAttribute('src', owner_photo_url.toString());
            } else {
                container.setAttribute('class', 'chat-container darker');
                time.setAttribute('class', 'time-left');
                image.setAttribute('class', 'right');
                image.setAttribute('src', customer_photo_url.toString());
            }


            container.appendChild(image);
            container.appendChild(msgContainer);


            body.appendChild(container);
            body.scrollTop = body.scrollHeight;
        }

        //INITIAL SETMESSAGES
        const setMessages = (messageList) => {
            messageList.forEach(function(arrayItem) {
                setMessage(arrayItem);
            });

        };

        const getMessages = async () => {

            let messagesList = [];

            const customerMessages = await get(child(dbRef, `conversation/${id}/${customer_id}`)).then((
                snapshot) => {
                if (snapshot.exists()) {
                    return snapshot.val();
                }
                return {
                    messages: []
                };
            }).catch((error) => {
                console.error(error);
            });

            if (customerMessages) {
                messagesList = Object.values(customerMessages.messages).map((m) => {
                    m.sender = 'customer';
                    m.name = customer_name;
                    return m;
                });
            }


            const ownerMessages = await get(child(dbRef, `conversation/${id}/${owner_id}`)).then((
                snapshot) => {
                if (snapshot.exists()) {
                    return snapshot.val();
                }
                return {
                    messages: []
                };
            }).catch((error) => {
                console.error(error);
            });

            if (ownerMessages) {
                const otherMessages = Object.values(ownerMessages.messages)
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

            setMessages(_sortMessagesByDate(messagesList));

        };
        getMessages();

        const customerRef = ref(getDatabase(), `/conversation/${id}/${customer_id}`);


        onValue(customerRef, (snapshot) => {
            const data = snapshot.val();

            const itemArr = data ? Object.values(data.messages) : [];

            const item = itemArr[itemArr.length - 1];
            item.sender = "customer";
            item.name = customer_name;

            setMessage(item);
        });

        const getDatetimeString = () => {
            var m = new Date();
            var dateString =
                m.getUTCFullYear() + "-" +
                ("0" + (m.getUTCMonth() + 1)).slice(-2) + "-" +
                ("0" + m.getUTCDate()).slice(-2) + " " +
                ("0" + m.getUTCHours()).slice(-2) + ":" +
                ("0" + m.getUTCMinutes()).slice(-2) + ":" +
                ("0" + m.getUTCSeconds()).slice(-2);
            return dateString;
        }

        //SEND MESSAGES
        const sendMessage = (message) => {
            const db = getDatabase();
            const senderNameRef = ref(db, `/conversation/${id}/${owner_id}`);
            const updates = {
                name: owner_name,
                id: owner_id
            };
            update(senderNameRef, updates);

            const messageListRef = ref(db, `/conversation/${id}/${owner_id}/messages`);
            const newMessageRef = push(messageListRef);
            const key = newMessageRef.key;

            const messageObj = {
                id: key,
                type: "text",
                message: message,
                time: moment(firestore.Timestamp).format('YYYY-MM-DDTHH:mm:ss'),
            };
            set(newMessageRef, messageObj);
            setMessage({
                ...messageObj,
                name: owner_name
            });
        }

        const sendReply = (message) => {
            const db = getDatabase();
            const messageListRef = ref(db, `/conversation/${id}/${customer_id}/messages`);
            const newMessageRef = push(messageListRef);
            const key = newMessageRef.key;

            const messageObj = {
                id: key,
                type: "text",
                message: message,
                time: moment(firestore.Timestamp).format('YYYY-MM-DDTHH:mm:ss'),
            };
            set(newMessageRef, messageObj);
            // setMessage(messageObj);
        }




        $("#send-message").click(function() {
            var message = $("#my-message").val();
            $("#my-message").val("");
            $.ajax({
                type: "POST",

                url: "{{ route('messages.conversation.send', ['order' => $conversation_id]) }}",
                data: {
                    message: message
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    sendMessage(message);

                }
            });
        });
</script>



@endsection
