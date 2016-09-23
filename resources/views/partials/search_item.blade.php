@foreach($data as $company)
    <li class="list-group-item">
        <div  class="row">
            <div class="col-md-9">
                <a target="_blank" href="/company/show/{{$company->id}}"><h5>{{$company->name}}</h5></a>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary pull-right">
                    <i class="glyphicon glyphicon-plus"></i> 关注
                </button>
            </div>
        </div>

        <div class="row" style="margin: 6px 0;">
            <b>{{$company->business_address}} {{$company->address_details}}</b>
            @if($company->circle)
                ({{$company->circle->name}})
            @endif
        </div>

        <div class="row dotdotdot" style="padding-left: 15px;padding-right: 15px;">
            <pre style="white-space: pre-wrap;word-wrap: break-word;border: 0px;">{{$company->profile}}</pre>
        </div>

        {{--<div class="btn-group">
            <button class="btn btn-white btn-xs"><i class="fa fa-thumbs-up"></i> 赞</button>
            <button class="btn btn-white btn-xs"><i class="fa fa-comments"></i> 评论</button>
            <button class="btn btn-white btn-xs"><i class="fa fa-share"></i> 分享</button>
        </div>--}}
    </li>
@endforeach
