$(function(){
	// 建立使用者
	$('#create_user').click(function(){
		$('#user_card_bg').show();
		$('#user_card').show();
	});
	$('#close_user_card').click(()=>{
		$('#user_card_bg').hide();
		$('#user_card').hide();
	});

	// 刪除使用者
	$('#delete_user').click(()=>{
		$('#delete_users').show();
		$('#delete_users_bg').show();
	});
	$('#close_delete_users').click(()=>{
		$('#delete_users').hide();
		$('#delete_users_bg').hide();
	});

	// 修改使用者
	$('#edit_user').click(()=>{
		$('#edit_users').show();
		$('#edit_users_bg').show();
	});
	$('#close_edit_users').click(()=>{
		$('#edit_users').hide();
		$('#edit_users_bg').hide();
	});

	// 建立專案
	$('#cp').click(()=>{
		$('#cps').show();
		$('#cps_bg').show();
	});
	$('#close_cps').click(()=>{
		$('#cps').hide();
		$('#cps_bg').hide();
	});


	// 指派專案成員
	$('#epm').click(()=>{
		$('#epms').show();
		$('#epms_bg').show();
	});
	$('#close_epms').click(()=>{
		$('#epms').hide();
		$('#epms_bg').hide();
	});

	// 修改專案成員
	$('#apm').click(()=>{
		$('#apms').show();
		$('#apms_bg').show();
	});
	$('#close_apms').click(()=>{
		$('#apms').hide();
		$('#apms_bg').hide();
	});

	// 修修改專案
	$('#ep').click(()=>{
		$('#eps').show();
		$('#eps_bg').show();
	});
	$('#close_eps').click(()=>{
		$('#eps').hide();
		$('#eps_bg').hide();
	});

});

// 建立專案
var flag_pjt = 2;
function add_pjt(){
	if(flag_pjt <= 10){
		$("#pjt_box").append("<div><label>面相標題：</label><input class=\"input\" type=\"text\" id=\"pjt_name_"+flag_pjt+"\"></div><div><label>面相說明：</label><input class=\"input\" type=\"text\" id=\"pjt_dec_"+flag_pjt+"\"></div>");
		flag_pjt++;
	}
}

function pjt_load(){
	var string1;
	var string2;
	var object="";
	for (let index = 1; index < flag_pjt; index++) {
		string1 = $('#pjt_name_'+index.toString()).val();
		string2 = $('#pjt_dec_'+index.toString()).val();
		if(string1!= undefined || string2 != undefined){
			object = object + "/" + string1 + ":" +string2
		}
	}
	$('#pjt_array').attr('value', object);
	return true;
}
