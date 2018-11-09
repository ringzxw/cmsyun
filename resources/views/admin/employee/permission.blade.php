<div class="row">


   @foreach($permissionGroups as $permissionGroup)
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $permissionGroup['name'] }}</h3>
                    <div class="pull-right">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a class="btn btn-sm btn-success">
                                <i class="fa fa-save"></i>&nbsp;&nbsp;保存设置
                            </a>
                        </div>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body" style="display: block;" id="permission">
                    @foreach($permissionGroup['list'] as $permission)
                        <div class="col-md-1"><input type="checkbox" @if(\Encore\Admin\Facades\Admin::user()->can($permission->slug)) checked @endif class="permission {{ $permission->is_all }}" name="permission" value="{{$permission->id}}"/>&nbsp;&nbsp;{{ $permission->name }}&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    @endforeach
                    <input type="hidden" name="permission[]">
                </div><!-- /.box-body -->
            </div>
        </div>
   @endforeach




</div>
<script>
    $(function () {
        $("input[type='checkbox'],input[type='radio']").iCheck({
            labelHover : false,
            cursor : true,
            checkboxClass : 'icheckbox_square-blue',
            radioClass : 'iradio_square-blue',
            increaseArea : '20%'
        });
        // $('.permission').iCheck({checkboxClass:'icheckbox_minimal-blue'});
    });

    $('.btn-success').unbind('click').click(function () {
        var ids  = [];
        $.each($("input[type='checkbox']"),function(){
            if(this.checked){
                ids.push($(this).val());
            }
        });
        swal({
            title: '确认设置操作？',
            text:"设置此员工相关权限",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            preConfirm: function(result) {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        method: 'post',
                        url: '/admin/api/employee-permission-setting',
                        dataType: "json",
                        data: {
                            _token:LA.token,
                            ids: ids,
                            employee_id:"{{ $id }}",
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
    });


    $('.all').on('ifChecked', function(event){
        $("input[type='checkbox']").iCheck('check');
    });

    $('.all').on('ifUnchecked', function(event){
        if($('.single:checked').length===$('.single').length){
            $("input[type='checkbox']").iCheck('uncheck');
        }
    });

    $('.single').on('ifChecked', function(event){
        if($('.single:checked').length===$('.single').length){
            $('.all').iCheck('check');
        }else {
            $('.all').iCheck('uncheck');
        }
    });

    $('.single').on('ifUnchecked', function(event){
        if($('.single:checked').length===$('.single').length){
            $('.all').iCheck('check');
        }else {
            $('.all').iCheck('uncheck');
        }
    });

</script>