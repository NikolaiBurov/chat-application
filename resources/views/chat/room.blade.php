@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">

    <div class="chat">
        <div class="chat-header clearfix">
            <div class="row">
                <div class="col-lg-6">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                    </a>
                    <div class="chat-about">
                        <h6 class="m-b-0">Aiden Chavez</h6>
                        <small>Last seen: 2 hours ago</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-history" id="messages">
            <ul class="m-b-0">
                @if(!is_null($messages))
                    @foreach($messages as $message)
                        @if($message->sender_id === auth()->user()->id)
                            <li class="clearfix">
                                <div class="message-data">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                    <span
                                        class="message-data-time">{{$message->created_at->format('h:i')}}, Today</span>
                                </div>
                                <div class="message my-message">{{$message->sender->name}}:{{$message->content}}</div>
                            </li>
                        @else
                            <li class="clearfix">
                                <div class="message-data text-right">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="avatar">
                                    <span class="message-data-time">{{$message->created_at->format('h:i')}},Today</span>
                                </div>
                                <div class="message other-message float-right">
                                    {{$message->sender->name}}:{{$message->content}}
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>

        <form id="chat-form">
            <div class="input-group mb-0">
                <div class="input-group-prepend">
                    <button type="submit">Send</button>
                </div>
                <input type="text" class="form-control" id="message-input" placeholder="Type a message">
            </div>
        </form>
    </div>


    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>
    <script>
    $(document).ready(function() {
          window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '783d5f7b732bb56c3cf8',
            cluster: 'eu',
            forceTLS: true
        });

        var token = $('meta[name="csrf-token"]').attr('content');
        var userOne = {{ app('request')->input('userOne')  }};
        var userTwo = {{ app('request')->input('userTwo')  }};

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        window.Echo.private('chat.{{$roomId}}')
        .listen('.message', (data) => {
         const chatMessagesElement = document.getElementById('messages');

         const listItemElement = document.createElement('li');
         listItemElement.classList.add('clearfix');
            if(data.sender.id === {{ auth()->user()->id }}){
               listItemElement.innerHTML = `
                    <div class="message-data">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                        <span class="message-data-time">${data.sentDate}, Today</span>
                    </div>
                    <div class="message my-message">${data.sender.name}: ${data.message}</div>
                `;
            }else{
             listItemElement.innerHTML = `
                <div class="message-data text-right">
                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="avatar">
                    <span class="message-data-time">${data.sentDate}, Today</span>
                </div>
                <div class="message other-message float-right">${data.sender.name}: ${data.message}</div>
                `;
            }
        chatMessagesElement.appendChild(listItemElement);
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

