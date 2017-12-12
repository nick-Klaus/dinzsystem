jQuery(function ($) {
	$('.am-btn-default').click(function(){
	$('#act').val('loginyes');
	if($('#admin_user').val() && $('#admin_pwd').val())
	{
		document.adminform.target = 'gtr';
		document.adminform.action = 'inc/active.php';	
		$('#stits').html('登录验证中，请稍后.....');
		$('#my-modal-loading').modal();
	}
   });

})


