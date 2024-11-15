<div class='direct-chat-msg left'>
    <div class='direct-chat-info clearfix'>
        <span class='direct-chat-name pull-left'>{{ $name }}</span>
        <span class='direct-chat-timestamp pull-right'>{{ date('d M h:i a') }}</span>
    </div>
    <img class='direct-chat-img' title='' src='{{ url('resources/img/receiver.png') }}' alt='Message User Image'>
    <div class='direct-chat-text'>
        {{ $message }}
    </div>
</div>