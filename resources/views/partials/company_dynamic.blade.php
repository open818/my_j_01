<!-- Login -->
<div class="company_dynamic">
    <input type="hidden" id="lastTime" />
    <ul class="list-group">
    </ul>
</div>

<script>
    function loadDynamicData(){
        time = $('#lastTime').val();
        var url = "/company_dynamic/{{$data->id}}/"+time;

        $.ajax({
            type: 'GET',
            url: url ,
            success: function(data) {
                var _ul = $('.company_dynamic > ul');
                $.each(data,function(n,value){
                    $("<li class=\"list-group-item\"><small class=\"block text-muted\"><i class=\"fa fa-clock-o\"></i>"+data.created_at+"</small><p>"+data.content+"</p></li>").appendTo(_ul);
                });
            } ,
            dataType: 'json'
        });
    }

    $(document).ready(function(){
        loadDynamicData();
    });

</script>