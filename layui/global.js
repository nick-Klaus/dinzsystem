// JavaScript Document

$(function(){
		   
      $.post("./tpl/nav.php",null,function(data){
	      $('.admin_nav').html(data);
		  

		  
		  
		  
	  });
	  
	  
	  

});