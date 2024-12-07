@if(isset($message_content) && empty($message_content))<h2>Please check following attachment details.</h2>@else
<p>{!! (!empty($message_content)) ? $message_content : '' !!}</p>@endif