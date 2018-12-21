<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="msg-width">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning" id="msg-total"></span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu"  id="msg-list">
            </ul>
        </li>
        <li class="footer"><a href="/admin/employee-message">点击查看全部消息</a></li>
    </ul>
</li>
<script>
    getData(); // 第一次加载数据
    // 开启定时任务，时间间隔为60000 ms。
    setInterval(function(){
        getData();
    }, 6000000);
    function getData(){
        $.getJSON("/admin/api/message", function(json){
            if(json.code === 200){
                $("#msg-width").css("width",json.data.width+'px')
                $("#msg-total").html(json.data.total)
                if(json.data.total <= 0){
                    $("#msg-list").append('<h2 style="text-align: center;margin-top: 30%">暂无新的消息</h2>')
                }else {
                    var list = json.data.list;
                    $.each(list, function(i,itme){
                        $("#msg-list").append(itme.html)
                    });
                }
            }
        });
    };
</script>