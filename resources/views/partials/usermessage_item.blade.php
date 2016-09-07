@foreach($data as $message)
    <li class="list-group-item">
        <small class="block text-muted"><i class="fa fa-clock-o"></i>{{$message->created_at}} {{$message->from_user->name}}({{$message->from_user->mobile}})</small>
        @if($message->isread == 'N')
        <span class="label label-danger pull-right">NEW</span>
        @endif
        <p>{{$message->content}}</p>
    </li>
@endforeach

