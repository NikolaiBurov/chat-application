@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">

    <div class="chat">
        <div class="chat-header clearfix">
            //s kogo si pishesh
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
{{--                <div class="col-lg-6 hidden-sm text-right">--}}
{{--                    <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>--}}
{{--                    <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>--}}
{{--                    <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>--}}
{{--                    <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>--}}
{{--                </div>--}}
            </div>
        </div>
        <div class="chat-history" id="messages">
            //left
            <ul class="m-b-0">
                <li class="clearfix">
                    <div class="message-data text-right">
                        <span class="message-data-time">10:10 AM, Today</span>
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                    </div>
                    <div class="message other-message float-right"> Hi Aiden, how are you? How is the project coming along? </div>
                </li>
            </ul>
            //right
            <ul class="m-b-0">
                <li class="clearfix">
                    <div class="message-data text-left">
                        <span class="message-data-time">10:10 AM, Today</span>
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                    </div>
                    <div class="message other-message float-left"> Hi Aiden, how are you? How is the project coming along? </div>
                </li>
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

{{--    <title>Pusher Test</title>--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--    <h1>Messages</h1>--}}
{{--    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />--}}

{{--    <div class="chat-container">--}}
{{--        <div id="messages"></div>--}}
{{--        <form id="chat-form">--}}
{{--            <input type="text" id="message-input" placeholder="Type a message">--}}
{{--            <button type="submit">Send</button>--}}
{{--        </form>--}}
{{--    </div>--}}

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

