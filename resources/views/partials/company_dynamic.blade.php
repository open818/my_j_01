<!-- Login -->
<div class="company_dynamic">
    @if(empty($data))
    <ul class="list-group">
        @foreach($data as $dynamic)
        <li class="list-group-item">
            <small class="block text-muted"><i class="fa fa-clock-o"></i> 1分钟前</small>
            <p><a class="text-info" href="index_3.html#">
                {{$dynamic->content}}
            </p>
        </li>
        @endforeach
    </ul>
    @endif
</div>