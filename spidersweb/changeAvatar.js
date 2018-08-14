
$(document).ready(function(){
    $("input[name='file']").change(function(){
        //FormData对象，
        //可以把form中所有表单元素的name与value组成一个queryString，提交到后台。
        //在使用Ajax提交时，使用FormData对象可以减少拼接queryString的工作量
        var formData = new FormData();
        formData.append("file",$("input[name='file']")[0].files[0]);
        $.ajax({
            url:'uploadimg.php',
            type:'post',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success:function(data){
                console.log(data);
                if(data.status!=0){
                    alert(data.message);
                }
                // #根据上传成功并返回压缩后的图片url，更新img标签src属性
                if(data.status==0){
                    $(".avatar img").attr("src",data.path+"?"+new Date().getTime());
                }
            },
            error:function(e){
                console.log(e);
            }
        });
    });
});
