@extends('layouts.app')

@section('content')
<title>Pusher Test</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<h1>Messages</h1>

<div class="chat-container">
    <div id="messages"></div>
    <form id="chat-form">
        <input type="text" id="message-input" placeholder="Type a message">
        <button type="submit">Send</button>
    </form>
</div>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        var token = $('meta[name="csrf-token"]').attr('content');
        var userOne = {{ app('request')->input('userOne')  }};
        var userTwo = {{ app('request')->input('userTwo')  }};

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('783d5f7b732bb56c3cf8', {
            cluster: 'eu',
            authEndpoint: 'http://chat-app.localhost/broadcasting/auth',
            auth: {
                headers: {
                    "X-CSRF-Token": token,
                    "Access-Control-Allow-Origin": "*"
                }
            }
        });
        //make this on private channel
       // const channel = pusher.subscribe('private-chat.{{$roomId}}');

        const channel = pusher.subscribe('chat-channel');

        channel.bind("message", (data) => {

            console.log(data)
            const chatMessagesElement = document.getElementById('messages');
            const messageElement = document.createElement('div');
            messageElement.classList.add('chat-message');
            messageElement.innerText = `${data.sender.name}: ${data.message}`;
            chatMessagesElement.appendChild(messageElement);
        });

        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');

        chatForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const message = messageInput.value.trim();
            if (message !== '') {
                // Send the message to the server
                fetch('{{ route('chat.send-message') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        message: message,
                        sender: userOne,
                        receiver: userTwo,
                        roomId:{{$roomId}}
    })
})
.then(response => response.json())
.then(data => {
    // Clear the input field
    messageInput.value = '';
})
.catch(error => {
    console.error('Error sending message:', error);
});
}
});
});

</script>
@endsection

