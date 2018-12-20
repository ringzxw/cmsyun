<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning">10</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu"  id="msg-count">
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-users text-aqua"></i> 5 new members joined today--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the--}}
                        {{--page and may cause design problems--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-users text-red"></i> 5 new members joined--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-shopping-cart text-green"></i> 25 sales made--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-user text-red"></i> You changed your username--}}
                    {{--</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li class="footer"><a href="#">View all</a></li>
    </ul>
</li>
<script>
    getData(); // 第一次加载数据
    // 开启定时任务，时间间隔为60000 ms。
    setInterval(function(){
        getData();
    }, 60000);
    function getData(){
        $.getJSON("/admin/api/count", function(json){
            if(json.code === 200){
                console.log(json.data)
                var msgs = json.data.msgs;
                var num = msgs.length;
                if(json.data.msgs.length > 0 ){
                    for (var j = 0; j < num; j++) {
                        var html = $('<li>' +
                            '<a href="#">' +
                            '<i class="fa fa-warning text-yellow"></i>' +
                            msgs[j].content +
                            '</a>' +
                            '</li>')
                        $("#msg-count").append(html)
                    }
                }



            }
        });
    };
</script>