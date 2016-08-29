<!-- Login -->
<div class="company_dynamic">
    @if(!empty($data))
    <ul class="list-group">
        @foreach($data as $dynamic)
        <li class="list-group-item">
            <small class="block text-muted"><i class="fa fa-clock-o"></i> {{$dynamic->created_at}}</small>
            <p>
                {{$dynamic->content}}
            </p>

        </li>
        @endforeach
    </ul>
    @endif
</div>

<script>
    function loadDynamicData(){
        var url = "/circle/dist";
        if($('#province').val() != ''){
            url = url + '/' + $('#province').val();
            if($('#city').val() != ''){
                url = url + '/' + $('#city').val();
            }
        }
        $.ajax({
            type: 'GET',
            url: url ,
            success: function(data) {
                $.each(data,function(n,value){
                    if(select_id == value.id){
                        $("<option selected value='" + value.id + "'>" + value.name + "</option>").appendTo(circle);//动态添加Option子项
                    }else{
                        $("<option value='" + value.id + "'>" + value.name + "</option>").appendTo(circle);//动态添加Option子项
                    }
                });
            } ,
            dataType: 'json'
        });
    }

</script>