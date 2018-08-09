var curPage = 1; //当前页码
var total,pageSize,totalPage;
//获取数据
function getData(page){
    $.ajax({
        type: 'POST',
        url: 'page.php',
        data: {'pageNum':page-1},
        dataType:'json',
        beforeSend:function(){
            $("#tablelist ").append("<h3>loading...</h3>");
        },
        success:function(json){
            $("#tablelist").empty();
            total = json.total; //总记录数
            pageSize = json.pageSize; //每页显示条数
            curPage = page; //当前页
            totalPage = json.totalPage; //总页数
            var table_html = "";
            table_html += "<table class=\"table\" width=\"800\" height=\"80\" border=\"1\" align=\"center\"><tr class=\"success\"><th>商品名称</th><th>商品描述</th><th>价格</th></tr>";
            var list = json.list;
            $.each(list,function(index,array){ //遍历json数据列
                if(array['name'].length > 28){
                 var title_sub = array['name'].substring(0,20); // 获取子字符串。
                }
                else var title_sub = array['name'];
                table_html += "<tr class=\"success\"><td>"+title_sub+"</td><td>"+array['desc']+"</td><td>"+array['price']+"</td><tr>";            
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

//获取分页条
function getPageBar(){
    //页码大于最大页数
    if(curPage>totalPage) curPage=totalPage;
    //页码小于1
    if(curPage<1) curPage=1;
    pageStr = "<div align=\"center\"><span style=\" border-radius: 40%;margin-left: 5px;\"class=\"btn btn-1 btn-default\">共"+total+"条"+curPage+"/"+totalPage+"</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    //如果是第一页
    if(curPage==1){
        pageStr += "<span class=\"btn btn-1 btn-default\">首页</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"btn btn-1 btn-default\">上一页</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }else{
        pageStr += "<span class=\"btn btn-1 btn-default\"><a href='javascript:void(0)' rel='1'>首页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"btn btn-1 btn-default\"><a href='javascript:void(0)' rel='"+(curPage-1)+"'>上一页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }

    //如果是最后页
    if(curPage>=totalPage){
        pageStr += "<span class=\"btn btn-1 btn-default\">下一页</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"btn btn-1 btn-default\">尾页</span>";
    }else{
        pageStr += "<span class=\"btn btn-1 btn-default\"><a href='javascript:void(0)' rel='"+(parseInt(curPage)+1)+"'>下一页</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"btn btn-1 btn-default\"><a href='javascript:void(0)' rel='"+totalPage+"'>尾页</a></span></div>";
    }
// 
    $("#pagecount").html(pageStr);
    regpageonclik();
}

$(function(){
    getData(1);
});

function regpageonclik()
{
    $("#pagecount span a").on('click',function(){
        var rel = $(this).attr("rel");
        if(rel){
            
            getData(rel);
            
        }
    });

}