var curPage = 1; //当前页码
var total,pageSize,totalPage,logflag;
//获取数据
function getData(page, size=30){
    $.ajax({
        type: 'POST',
        url: 'collectpage.php',
        data: {'pageNum':page-1,'pageSize':size},
        dataType:'json',
        success:function(json){
            $("#tablelist").empty();
            total = json.total; //总记录数
            pageSize = json.pageSize; //每页显示条数
            curPage = page; //当前页
            totalPage = json.totalPage; //总页数
            logflag = json.logflag;
             var table_html = "";
            if(logflag==1){
               
                table_html += "<table class=\"table\" width=\"800\" height=\"80\" border=\"1\" align=\"center\"><tr class=\"success\"><th>商品ID</th><th>商品名称</th><th>商品描述</th><th>价格</th><th>收藏</th></tr>";
                var list = json.list;
                $.each(list,function(index,array){ //遍历json数据列
                    if(array['name'].length > 28){
                    var title_sub = array['name'].substring(0,20); // 获取子字符串。
                    }
                    else var title_sub = array['name'];
                    table_html += "<tr class=\"success\"><td>"+array['id']+"</td><td>"+title_sub+"</td><td>"+array['desc']+"</td><td>"+array['price']+"</td><td><button class='"+array['collectclass']+" collect' id=\"collect\" gid='"+array['id']+"' status="+array['collectStatus']+">"+array['collect']+"</button></td><tr>";            
                });
                table_html += "</table>";
                $("#tablelist").append(table_html);
                var share_html = "<script src=\"http://tjs.sjs.sinajs.cn/open/api/js/wb.js\" type=\"text/javascript\" charset=\"utf-8\"></script><wb:share-button addition=\"simple\" type=\"button\" language=\"zh_cn\"  url=\"http://localhost/spidersweb/collectshare.html?id="+json.uid+"&name="+json.name+"\" title=\"我的心愿单\"></wb:share-button>";
                $("#weiboshare").append(share_html);
            }else{
                table_html = " <h1 align=\"center\" >请先登录后才能看见收藏哦</h1>"
                $("#tablelist").append(table_html);
            }
           
        },
        complete:function(

        ){ //生成分页条
            if(logflag==1){
                getPageBar(); 
                $("#pageSize").show();
            }else{
                $("#pageSize").hide();
            }
        },
        error:function(){
            alert("数据加载失败");
        }
    });
}

//改变收藏状态
function changeCollect(gid, collectStatus, thisitem){
    var collect;
    $.ajax({
        type: 'POST',
        url: 'collect.php',
        data: {'gid':gid,'collectStatus':collectStatus},
        dataType:'json',
        success:function(json){
            collect = json.collect; //收藏字段
            var status = json.collectStatus; //收藏状态
            var classtype = json.class;
            $(thisitem).text(collect);
            $(thisitem).attr("status", status);
            $(thisitem).attr("class", classtype);
        },
        error:function(){
            alert(collect+"失败");
        }
    });
}


//获取分页条
function getPageBar(){
    //页码大于最大页数
    if(curPage>totalPage) curPage=totalPage;
    //页码小于1
    if(curPage<1) curPage=1;
    pageStr = "<nav aria-label=\"Page navigation example\"><ul class=\"pagination\">";
    pageStr += "<li class=\"page-item\"><span style=\" border-radius: 40%;margin-left: 5px;\"class=\"btn btn-1 btn-default\">共"+total+"条"+curPage+"/"+totalPage+"</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    //如果是第一页
    if(curPage==1){
        pageStr += "<li class=\"page-item disabled\"><span class=\"page-link\">首页</span></li><li class=\"page-item disabled\"><span class=\"page-link\"><span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span></span></li>";
    }else{
        pageStr += "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" rel='1'>首页</a></li><li class=\"page-item\"><a class=\"page-link\" href=\"#\" aria-label=\"Previous\" rel='"+(parseInt(curPage)-1)+"'><span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span></a></li>";
    }
    if(curPage<=(totalPage-2)){
        pageStr += "<li class=\"page-item active\"><span class=\"page-link\" id=\"currentpage\" rel='"+(parseInt(curPage))+"'>"+(parseInt(curPage))+"<span class=\"sr-only\">(current)</span></li><li class=\"page-item\"><a class=\"page-link\" href=\"#\" rel='"+(parseInt(curPage)+1)+"'>"+(parseInt(curPage)+1)+"</a></li><li class=\"page-item\"><a class=\"page-link\" href=\"#\" rel='"+(parseInt(curPage)+2)+"'>"+(parseInt(curPage)+2)+"</a></li>";

    }else if(curPage==(totalPage-1)){
        pageStr += "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" rel='"+(parseInt(curPage)-1)+"'>"+(parseInt(curPage)-1)+"</a></li><li class=\"page-item active\"><span class=\"page-link\" id=\"currentpage\" rel='"+(parseInt(curPage))+"'>"+(parseInt(curPage))+"<span class=\"sr-only\">(current)</span></li><li class=\"page-item\"><a class=\"page-link\" href=\"#\" rel='"+(parseInt(curPage)+1)+"'>"+(parseInt(curPage)+1)+"</a></li>";

    }else if(curPage==totalPage){
        pageStr += "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" rel='"+(parseInt(curPage)-2)+"'>"+(parseInt(curPage)-2)+"</a></li><li class=\"page-item\"><a class=\"page-link\" href=\"#\" rel='"+(parseInt(curPage)-1)+"'>"+(parseInt(curPage)-1)+"</a></li><li class=\"page-item active\"><span class=\"page-link\" id=\"currentpage\" rel='"+(parseInt(curPage))+"'>"+(parseInt(curPage))+"<span class=\"sr-only\">(current)</span></li>";
    }
    //如果是最后页
    if(curPage>=totalPage){
        pageStr += "<li class=\"page-item disabled\"><span class=\"page-link\"><span aria-hidden=\"true\">&raquo;</span><span class=\"sr-only\">Next</span></span></li><li class=\"page-item disabled\"><span class=\"page-link\">尾页</span></li>";
    }else{
        pageStr += "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" aria-label=\"Next\" rel='"+(parseInt(curPage)+1)+"'><span aria-hidden=\"true\">&raquo;</span><span class=\"sr-only\">Next</span></a></li><li class=\"page-item\"><a class=\"page-link\" href=\"#\" rel="+totalPage+">尾页</a></li>";
    }
    pageStr += "";

    pageStr += "";

    pageStr += "</ul></nav>";
    $("#pagecount").html(pageStr);
    regpageonclik();
    collectonclick();
}

$(function(){
    getData(1);
    $("#pageSize").on('change',function(){
        var size = $(this).val();
        var rel = 1;
        if(size!=0){
            getData(rel, size);
        }
    });
    $("#searchsubmit").on('click',function(){
        var size = $("#pageSize").val();
        var rel = 1;
        // alert(where);
        if(size!=0){
            getData(rel, size);
        }else{
            size = 30;
            getData(rel, size);
        }
        
        
    });
    collectonclick();
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

//收藏点击时间函数
function collectonclick(){
    $(".collect").on('click',function(){
        var gid = $(this).attr("gid");
        var collectStatus=$(this).attr("status");
        var thisitem = $(this);
        changeCollect(gid, collectStatus, thisitem);
    });
}