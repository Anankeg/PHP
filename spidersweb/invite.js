function GetRequest() { 
	var url = location.search; //获取url中"?"符后的字串 
	var theRequest = new Object(); 
	if (url.indexOf("?") != -1) {
		var str = url.substr(1); 
		strs = str.split("&"); 
		for(var i = 0; i < strs.length; i ++) {
			theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]); 
		} 
	} 
	return theRequest; 
} 


$(document).ready(function(){
	var s_url = location.search;
	var urlparam = GetRequest();
	var parentid = urlparam['id'];
	if(parentid){
		$("#parentid").val(parentid);
		$("#parentid").hide();
		$("#parenturl").val(s_url);
    	$("#parenturl").hide();
	}else{
		$(".details-section").empty();
		var invitefail_html = "<h1 align=\"center\" >此分享已失效哦</h1>";
		$(".details-section").append(invitefail_html);

	}
    
});