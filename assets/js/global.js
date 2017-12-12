// JavaScript Document
String.prototype.trim = function() {
	a = this.replace(/^\s+/, ''); return a.replace(/\s+$/, '');
}


function M(id){
return document.getElementById(id);//用M()方法代替document.getElementById(id)
}
function MC(t){
return document.createElement(t);//用MC()方法代替document.createElement(t)
};


function open_pic_box(id)
{
   
   $('.frameBorder').html('<IFRAME frameBorder=0 id="gtr" name="gtr" scrolling=no src="./inc/pic.php?inputname='+id+'" style="HEIGHT:500px; VISIBILITY: inherit; WIDTH:100%; Z-INDEX: 1"> </IFRAME>');
   $('#my-popup').modal();
}


document.writeln("<div class=\"am-popup am-round-s\" id=\"my-popup\">");
document.writeln("  <div class=\"am-popup-inner am-round-s\">");
document.writeln("    <div class=\"am-popup-hd am-round-s\">");
document.writeln("      <h4 class=\"am-popup-title\">我的图片盒</h4>");
document.writeln("      <span data-am-modal-close");
document.writeln("            class=\"am-close\">&times;</span>");
document.writeln("    </div>");
document.writeln("    <div class=\"am-popup-bd frameBorder\">");
document.writeln("     <IFRAME frameBorder=0 id=\"gtr\" name=\"gtr\" scrolling=auto src=\"\" style=\"HEIGHT:30em; VISIBILITY: inherit; WIDTH:100%; Z-INDEX: 1\"> </IFRAME>");
document.writeln("    </div>");
document.writeln("  </div>");
document.writeln("</div>");


document.writeln("<div class=\"am-modal am-modal-alert am-round-s\" tabindex=\"-1\" id=\"my-alert\">");
document.writeln("  <div class=\"am-modal-dialog am-round-s\">");
document.writeln("    <div class=\"am-modal-hd\" id=\"errortit\" >提交错误</div>");
document.writeln("    <div class=\"am-modal-bd\" id=\"errorcode\" style=\"color:red\">");
document.writeln("      Hello world！");
document.writeln("    </div>");
document.writeln("    <div class=\"am-modal-footer\">");
document.writeln("      <span class=\"am-modal-btn popsubmit\">确定</span>");
document.writeln("    </div>");
document.writeln("  </div>");
document.writeln("</div>");

document.writeln("</div>");
document.writeln("");
document.writeln("<div class=\"am-modal am-modal-loading am-modal-no-btn am-round-s\" tabindex=\"-1\" id=\"my-modal-loading\">");
document.writeln("  <div class=\"am-modal-dialog am-round-s\">");
document.writeln("    <div class=\"am-modal-hd stits\">请稍后... </div>");
document.writeln("    <div class=\"am-modal-bd scons\">");
document.writeln("      <span class=\"am-icon-spinner am-icon-spin\"></span>");
document.writeln("    </div>");
document.writeln("  </div>");
document.writeln("</div>");

document.writeln("<div class=\"am-modal am-modal-prompt am-round-s\" tabindex=\"-1\" id=\"my-prompt\">");
document.writeln("  <div class=\"am-modal-dialog am-round-s\">");
document.writeln("    <div class=\"am-modal-hd\" id=\"poptit\"></div>");
document.writeln("    <div class=\"am-modal-bd\" id=\"popcon\">");
document.writeln("");
document.writeln("    </div>");
document.writeln("    <div class=\"am-modal-footer\">");
document.writeln("      <span class=\"am-modal-btn\" data-am-modal-cancel>继续浏览</span>");
document.writeln("      <span class=\"am-modal-btn\" data-am-modal-confirm onClick=\"goto(\'cart.php\')\">查看购物车</span>");
document.writeln("    </div>");
document.writeln("  </div>");
document.writeln("</div>");


document.writeln("<div class=\"am-modal am-modal-confirm\" tabindex=\"-1\" id=\"my-confirm\">");
document.writeln("  <div class=\"am-modal-dialog\">");
document.writeln("    <div class=\"am-modal-hd\">管理确认</div>");
document.writeln("    <div class=\"am-modal-bd\">");
document.writeln("      你，确定要删除这条记录吗？");
document.writeln("    </div>");
document.writeln("    <div class=\"am-modal-footer\">");
document.writeln("      <span class=\"am-modal-btn\" data-am-modal-cancel>取消</span>");
document.writeln("      <span class=\"am-modal-btn\" data-am-modal-confirm>确定</span>");
document.writeln("    </div>");
document.writeln("  </div>");
document.writeln("</div>");




	function dblupdate(id,lang)
	{
	     
		  var txt = $('#'+id).html();
		  if(txt.indexOf('input')==-1)
		  {
			  var newhtml = "<input type='text' name='new_clsname' id='new_clsname' style='width:60px' value='"+txt+"'>";
			  $('#'+id).html(newhtml);
			  $('#new_clsname').focus();
			  $('#new_clsname').blur(function(){
				 //alert(this.value);
				 //提交数据和还原
				 var langarr = lang.split(':');
				  var url = "./inc/active.php?act="+langarr[0];
				// alert(url);
				 $.post(url,{id:id,val:$('#new_clsname').val(),uuid:langarr[1]},
						  function(data){
							if(data)
							{
								   //alert(data);
									if(data.indexOf('ok')!=-1)
									{
										 $('#'+id).html($('#new_clsname').val());
									}
							}
						
						  },"text");
			    });
		  }	  
	}
	
	
	function update_ico_pic(id,pic)
	{   
	
	            var url = "./inc/active.php?act=upd_box_pic";
				 
				 $.post(url,{id:id,val:pic},
						  function(data){
							if(data)
							{
 
							}
						
						  },"text");
	}