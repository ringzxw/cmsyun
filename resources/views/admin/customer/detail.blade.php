<style>
    .row {
        margin-right: 0px;
        margin-left: 0px;
        margin-bottom: 10px;
    }
    .container-fluid{
        margin-bottom: 20px;
    }
    .vertical-bar {
        float: left;
        margin-right: 9px;
        width:5px;
        height:20px;
        background:inherit;
        background-color:rgba(255, 153, 0, 1);
        border:none;
        border-radius:0px;
        -moz-box-shadow:none;
        -webkit-box-shadow:none;
        box-shadow:none;
    }
    hr{
        margin-right: 50px;
        margin-top: 10px;
        margin-bottom: 10px;
        border-top: 1px solid #eee;
    }
</style>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">详细信息</h3>
        <div class="box-tools pull-right">
            <a href="javascript:history.back(-1)" class="btn btn-default btn-xs">返回</a>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body" style="display: block;">
        <div>
            <div class="container-fluid">
                <div class="vertical-bar"></div><p class="text-left h7">客户基本信息</p>
                <div class="row">
                    <div class="col-md-12"><span style="color:#666666;">姓名：</span><span style="color:#000000;">{{ $customer->name }}</span></div>
                </div>

                <div class="row">
                    <span class="col-md-6 col-sm-6 col-xs-6"><span style="color:#666666;">手机号：</span>{{ $customer->mobile }}</span>
                    <span class="col-md-6 col-sm-6 col-xs-6"><span style="color:#666666;">状态：</span>{{ $customer->status_html }}</span>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
<script>
</script>



