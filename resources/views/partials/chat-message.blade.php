@foreach($messages as $message)
    <x-chat-bubble 
        :sender="$message['sender']" 
        :contentType="'text'"
        :avatar="$message['avatar']"
    >
      {!! $message['content'] !!}
    </x-chat-bubble>
@endforeach
