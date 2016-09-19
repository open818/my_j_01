<!-- Login -->
<div class="panel panel-default">
    <div class="panel-body">
        @if(Auth::user()->company)
        <div class="col-md-12 text-center">
            <a target="_blank" href="/company/show/{{Auth::user()->company->id}}">
                <h5>{{Auth::user()->company->name}}</h5>
                @if(Auth::user()->company->status == 2)
                    <small>(待验证)</small>
                @endif
            </a>
        </div>
        @endif
        <div class="col-md-12 text-center">
            <a href="/user/profile">{{Auth::user()->name}}</a>  <small><a href="/logout">退出</a></small>
        </div>


        <div class="col-md-12">
            <div class="col-md-5 text-center h4">
                <a href="">0<br>关注</a>
            </div>
            <div class="col-md-2 text-center h4" style="padding-top: 10px;">|</div>
            <div class="col-md-5 text-center h4">
                @if(Auth::user()->company)
                    <a href="/company/show/{{Auth::user()->company->id}}">
                        {{ \App\Models\CompanyDynamic::where('company_id', Auth::user()->company->id)->count()  }}<br>商机
                    </a>
                @else
                    <a href="/user/relevancy">企业关联</a>
                @endif

            </div>
        </div>
    </div>
</div>
