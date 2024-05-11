@extends('Dashboard/layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('title')
   {{__('Dashboard/index.Billingmanagement')}}
@endsection
@section('content')

    <span>Live Chat With {{$receiver->name}}</span>
    <div id="chat_area">
    </div>

    <textarea rows="5" id="message"></textarea>

    <button id="send">Send</button>
@endsection
@section('js')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        $("#send").click(function (){
            // $.post("/chat/{{$receiver->id}}",
            // {
            //     message: $('message').val(),
            // }
            function(data, status){
                console.log('mmmmmmmmm');
                // let senderMessage = '<span>'+$("#message").val()+'</span>';
                // $('#chat_area').append(senderMessage);
            }
        // )
        });

        Pusher.logToConsole = true;

        var pusher = new Pusher('2afdb5431f6a81c18a3d', {
        cluster: 'eu'
        });

        var channel = pusher.subscribe('chat{{auth()->user()->id}}');
        channel.bind('chatMessage', function(data) {
            let receiverMessage = '<span>'+JSON.stringify(data)+'</span>';
            $('#chat_area').append(receiverMessage);
        });
    </script>
@endsection
