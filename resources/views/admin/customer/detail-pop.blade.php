<div style="OVERFLOW-Y: scroll; OVERFLOW-X:hidden; height: 400px;width: 800px;">
    <table class="table table-bordered" style="text-align: center">
        <tr><td colspan="6">客户信息</td></tr>
        <tr>
            <td class="td-label col-md-2">姓名</td><td class="col-md-3">{{$customer->name}}</td>
            <td class="td-label col-md-2">手机号</td><td class="col-md-3">{{$customer->mobile}}</td>
            <td class="td-label col-md-2">性别</td><td class="col-md-3">{{$customer->mobile}}</td>
        </tr>
        <tr>
            <td class="td-label col-md-2">状态</td><td class="col-md-3">{!! $customer->status_html !!}</td>
            <td class="td-label col-md-2">意向</td><td class="col-md-3">{!! $customer->labels_html !!}</td>
            <td class="td-label col-md-2">性别</td><td class="col-md-3">{{$customer->mobile}}</td>
        </tr>
        <tr>
            <td class="td-label col-md-2">最新跟进</td><td class="col-md-3">{{\App\Utils\DateUtil::dateFormat($customer->created_at)}}</td>
            <td class="td-label col-md-2">最新来访</td><td class="col-md-3">{{\App\Utils\DateUtil::dateFormat($customer->created_at)}}</td>
            <td class="td-label col-md-2">最新成交</td><td class="col-md-3">{{\App\Utils\DateUtil::dateFormat($customer->created_at)}}</td>
        </tr>
        {{--<tr>--}}
            {{--<td class="td-label col-md-2">状态</td><td class="col-md-4">{!! $customer->status_html !!}</td>--}}
            {{--<td class="td-label col-md-2">意向</td><td class="col-md-4">{!! $customer->labels_html !!}</td>--}}
        {{--</tr>--}}
    </table>
</div>