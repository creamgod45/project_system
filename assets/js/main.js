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

	// 修改專案
	$('#ep').click(()=>{
		$('#eps').show();
		$('#eps_bg').show();
	});
	$('#close_eps').click(()=>{
		$('#eps').hide();
		$('#eps_bg').hide();
	});

	// 刪除專案
	$('#dp').click(()=>{
		$('#dps').show();
		$('#dps_bg').show();
	});
	$('#close_dps').click(()=>{
		$('#dps').hide();
		$('#dps_bg').hide();
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

var object = [];     // 主要儲存容器
function php_subject_load(_layer, _array_val){
	for(const [key,value] of Object.entries(_array_val)){
		if(key != undefined && value != undefined){
			object[_layer][key] = value;
		}
	}
}

function subject_add(_layer){
	if(object[_layer].length <= 10){
		object[_layer][object[_layer].length]=["",""];
		$("#pjt_box" + _layer.toString()).html("");
		gen_subject(_layer);
	}
}

function gen_subject(_layer){
	var tmp_1="";
	var tmp_2="";
	var x = 1;
	for(var i=1;i<=10;i++){
		if(object[_layer][i] != undefined){
			for(const [key,value] of Object.entries(object[_layer][i])){
				if(key==0){
					tmp_1=value;
				}else if(key==1){
					tmp_2 = value;
					$("#pjt_box" + _layer.toString()).append('<div id="prj_frame'+_layer.toString()+'" style="border:solid 2px #000; padding:4px;"><div onclick="subject_remove(\''+_layer.toString()+'\',\'#prj_frame'+_layer.toString()+'\', '+i+')" style="float:right; display:block; text-align:right;">&times;</div><div><label>面相標題：</label><input class="input" value="'+tmp_1+'" type="text" id="pjt_name_'+_layer+'_'+i+'" required></div><div><label>面相說明：</label><input class="input" value="'+tmp_2+'" type="text" id="pjt_dec_'+_layer+'_'+i+'" required></div></div>');
				}
			}
		}
	}
}

function subject_remove(_layer, _target, _key){
	$(_target).remove();
	object[_layer].splice(_key, 1);
	var string1 = [];
	var string2 = [];
	for (let index = 1; index <= 10; index++) {
		if(index != _key){
			string1[index] = $('#pjt_name_'+_layer.toString()+'_'+index).val();
			string2[index] = $('#pjt_dec_'+_layer.toString()+'_'+index).val();
			if(string1[index] != undefined && string2[index] != undefined){
				delete object[_layer][_key];
			}
		}
	}
	if(string1[1] != undefined && string2[1] != undefined){php_subject_load(_layer , {1:[string1[1],string2[1]]});}
	if(string1[2] != undefined && string2[2] != undefined){php_subject_load(_layer , {2:[string1[2],string2[2]]});}
	if(string1[3] != undefined && string2[3] != undefined){php_subject_load(_layer , {3:[string1[3],string2[3]]});}
	if(string1[4] != undefined && string2[4] != undefined){php_subject_load(_layer , {4:[string1[4],string2[4]]});}
	if(string1[5] != undefined && string2[5] != undefined){php_subject_load(_layer , {5:[string1[5],string2[5]]});}
	if(string1[6] != undefined && string2[6] != undefined){php_subject_load(_layer , {6:[string1[6],string2[6]]});}
	if(string1[7] != undefined && string2[7] != undefined){php_subject_load(_layer , {7:[string1[7],string2[7]]});}
	if(string1[8] != undefined && string2[8] != undefined){php_subject_load(_layer , {8:[string1[8],string2[8]]});}
	if(string1[9] != undefined && string2[9] != undefined){php_subject_load(_layer , {9:[string1[9],string2[9]]});}
	if(string1[10] != undefined && string2[10] != undefined){php_subject_load(_layer , {10:[string1[10],string2[10]]});}
	$("#pjt_box" + _layer.toString()).empty();
	gen_subject(_layer);
}

function subject_load(_layer){
	var string1;
	var string2;
	var object="";
	for (let index = 1; index <= 10; index++) {
		string1 = $('#pjt_name_'+_layer.toString()+'_'+index).val();
		string2 = $('#pjt_dec_'+_layer.toString()+'_'+index).val();
		if(string1!= undefined || string2 != undefined){
			object = object + "/" + string1 + ":" +string2
		}
	}
	$('#pjt_array_'+_layer.toString()).attr('value', object);
	return true;
}


function fileAsData (file, key) {
	var reader = new FileReader();
	var query = reader.readAsDataURL(file.files[0]);
	reader.onload = function () {
		var res = [];
		res[0] = reader.result.split("/");
		res[1] = res[0][0].split(":");
	  	$('#dataurl'+key.toString()).attr('value', res[1][1]);
	  	$('#text_'+key.toString()).attr('value', "已經選擇檔案");
	  	$('#text_'+key.toString()).attr('disabled', true);
	};
}