<style>
    .customer-detail{
        OVERFLOW-Y: scroll;
        OVERFLOW-X:hidden;
        height: 400px;
        width: 800px;
    }
    .customer-detail td{
        font-size: 13px;
        vertical-align: middle;
        text-align: center;
    }
    .customer-detail .detail{
        font-size: 13px;
        color: gray;
    }
    .customer-follow{text-align: left !important;}
</style>
<div class="customer-detail">
    <table class="table table-bordered" >
        <tr><td colspan="12">客户信息</td></tr>
        <tr>
            <td class="td-label col-md-1" colspan="1">姓名</td><td class="col-md-3 detail" colspan="2">{{$customer->name}}</td>
            <td class="td-label col-md-1" colspan="1">电话</td><td class="col-md-3 detail" colspan="2">{{$customer->mobile}}</td>
            <td class="td-label col-md-1" colspan="1">性别</td><td class="col-md-3 detail" colspan="2">{{$customer->mobile}}</td>
        </tr>
        <tr>
            <td class="td-label col-md-1" colspan="1">状态</td><td class="col-md-3 detail" colspan="2">{!! $customer->status_html !!}</td>
            <td class="td-label col-md-1" colspan="1">意向</td><td class="col-md-3 detail" colspan="2">{!! $customer->labels_html !!}</td>
            <td class="td-label col-md-1" colspan="1">性别</td><td class="col-md-3 detail" colspan="2">{{$customer->mobile}}</td>
        </tr>
        <tr>
            <td class="td-label col-md-1" colspan="1">跟进</td><td class="col-md-3 detail" colspan="2">{{\App\Utils\DateUtil::dateFormat($customer->created_at)}}</td>
            <td class="td-label col-md-1" colspan="1">来访</td><td class="col-md-3 detail" colspan="2">{{\App\Utils\DateUtil::dateFormat($customer->created_at)}}</td>
            <td class="td-label col-md-1" colspan="1">成交</td><td class="col-md-3 detail" colspan="2">{{\App\Utils\DateUtil::dateFormat($customer->created_at)}}</td>
        </tr>
        <tr><td colspan="12">跟进记录</td></tr>
        @foreach($customer->follows as $follow)
            <tr>
                <td colspan="1" class="detail">{{$follow->creator->name}}</td>
                <td colspan="1" class="detail">{{\App\Utils\DateUtil::dateFormat($follow->created_at)}}</td>
                <td colspan="1" class="detail">{{$follow->creator->name}}</td>
                <td colspan="9" class="detail customer-follow">{!! $follow->content !!}</td>
            </tr>
        @endforeach
    </table>
</div>