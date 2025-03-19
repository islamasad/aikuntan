@foreach($messages as $message)
    <div class="message {{ $message['sender'] }}">
        <div class="avatar">{{ $message['avatar'] }}</div>
        <div class="content">
            {!! nl2br(e($message['content'])) !!}
            
            @if(isset($message['requires_input']))
                <div class="data-request mt-3">
                    @foreach($message['required_fields'] as $field)
                        <div class="input-group mb-2">
                            <input type="text" 
                                   class="form-control" 
                                   name="{{ $field }}" 
                                   placeholder="{{ ucfirst(str_replace('_', ' ', $field)) }}">
                        </div>
                    @endforeach
                    <button class="btn btn-sm btn-primary mt-2" 
                            hx-post="/chat/followup" 
                            hx-include="[name='{{ implode("'], [name='", $message['required_fields']) }}']">
                        Kirim Data
                    </button>
                </div>
            @endif
        </div>
    </div>
@endforeach