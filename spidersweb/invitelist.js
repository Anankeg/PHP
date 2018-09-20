var curPage = 1; //当前页码
var total,pageSize,totalPage;
//获取数据
function getData(page, size=30, where=null){
    $.ajax({
        type: 'POST',
        url: 'invitelist.php',
        data: {},
        dataType:'json',
        success:function(json){
            $("#tablelist").empty();
            var table_html = "";
            table_html += "<table class=\"table\" width=\"800\" height=\"80\" border=\"1\" align=\"center\"><tr class=\"success\"><th>商品ID</th><th>商品名称</th><th>商品描述</th><th>价格</th><th>收藏</th></tr>";
            var data = json.data;
            $.each(data,function(index,array){ //遍历json数据列
                if(array['name'].length > 28){
                 var title_sub = array['name'].substring(0,20); // 获取子字符串。
                }
                else var title_sub = array['name'];
                table_html += "<tr class=\"success\"><td>"+array['id']+"</td><td>"+title_sub+"</td><td>"+array['desc']+"</td><td>"+array['price']+"</td><td><button class='"+array['collectclass']+" collect' id=\"collect\" gid='"+array['id']+"' status="+array['collectStatus']+">"+array['collect']+"</button></td><tr>";            
            });
            table_html += "</table>";
            $("#tablelist").append(table_html);
        },
        complete:function(){ //生成分页条
            getPageBar();
        },
        error:function(){
            alert("数据加载失败");
        }
    });
}


$(function(){
    getData(1);
    $("#pageSize").on('change',function(){
        var size = $(this).val();
        var rel = 1;
        var where = $("#search").val();
        if(size!=0){
            getData(rel, size, where);
        }
    });
    
});

//分页点击事件函数
function regpageonclik()
{
    $("#pagecount li a").on('click',function(){
        var rel = $(this).attr("rel");
        var size=$("#pageSize").val();
        var where = $("#search").val();
        if(rel){
            if(size!=0){
                getData(rel,size,where);
            }else{
                size = 30;
            getData(rel, size, where);
            }
            
            
        }
    });
}
