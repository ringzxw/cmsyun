<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">详细</h3>
                <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a class="btn btn-sm btn-success" title="保存">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 保存</span>
                        </a>
                    </div>
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="/admin/employee" class="btn btn-sm btn-default" title="列表">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 列表</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
        </div>
    </div>


   @foreach($permissionGroups as $permissionGroup)
        <div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $permissionGroup->name }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="display: block;" id="permission">
                    @foreach($permissionGroup->permissions as $permission)
                        <div class="col-md-1 col-sm-2" style="margin-bottom: 20px;"><input type="checkbox" @if($employee->can($permission->slug)) checked @endif class="permission {{ $permission->all }}" name="permission" value="{{$permission->id}}"/><span style="margin-left: 5px;">{{ $permission->name }}</span></div>
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
                            employee_id:"{{ $employee->id }}",
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