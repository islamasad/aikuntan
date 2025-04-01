@foreach($messages as $message)
    <x-chat-bubble 
        :sender="$message['sender']" 
        :contentType="'text'"
    >
      {!! $message['content'] !!}
    </x-chat-bubble>
@endforeach
