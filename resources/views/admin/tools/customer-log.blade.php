<div class="box-body">
    <div class="col-xs-10">
        <h5>跟进记录流水</h5>
        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages" style="height: 500px;">
            <!-- Message. Default to the left -->
            @foreach($customerLogs as $customerLog)
                @if($customerLog['content'])
                    <div class="direct-chat-msg" onclick="setBest({{$customerLog['id']}})" style="cursor:pointer;">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-left">{{ $customerLog['employee_text'] }}      ==>> 主推项目：{{ $customerLog['subject_text'] }}</span>
                            <span class="direct-chat-timestamp pull-right">
                                @if($customerLog['best'])
                                <span class="badge bg-green">最佳</span>
                                @endif
                                <span class="badge" style="{{ $customerLog['type_color'] }}">{{ $customerLog['type_text'] }}</span>
                                {{ $customerLog['created_at'] }}
                            </span>
                        </div>
                        <!-- /.direct-chat-info -->
                        <div class="direct-chat-text pull-left">
                            {{ $customerLog['content'] }}
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                @endif
            @endforeach
        </div>
        <!--/.direct-chat-messages-->
    </div>
</div>
<style>
    .direct-chat-msg:hover{
        background-color: #CCCCCC;
    }
</style>
<script>
    function setBest(id) {
        swal({
            title: "确认此跟进为最佳?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "确认",
            closeOnConfirm: false,
            cancelButtonText: "取消",
            preConfirm: function(result) {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        method: 'post',
                        url: '/admin/api/set-best',
                        dataType: "json",
                        data: {
                            _token:LA.token,
                            id: id,
                        },
                        success: function (json) {
                            $.pjax.reload('#pjax-container');
                            if(json.status === 'success'){
                                swal(json.message, '', 'success');
                            }else{
                                swal(json.message, '', 'error');
                            }
                        }
                    });
                });
            },
        }).then(function(){

        })
    }
</script>