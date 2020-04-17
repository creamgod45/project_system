function filetype(file, key){
    var reader = new FileReader();
    reader.readAsDataURL(file.files[0]);
    reader.onload = () => {
        var res =[];
        res[0] = reader.result.split("/");
        res[1] = res[0][0].split(":");
        $("#file"+key.toString()).attr('value', res[1][1]);
    }
}

var pj_object = [];     // 主要儲存容器
function php_subject_load(_layer, _array_val){
	for(const [key,value] of Object.entries(_array_val)){
		if(key != undefined && value != undefined){
			pj_object[_layer][key] = value;
		}
	}
}

function add_pj(_layer){
    if(pj_object[_layer] == undefined){
        pj_object[_layer]=[];
        var num = pj_object[_layer].length;
    }
    var num = pj_object[_layer].length;
    if(num<=10){
        pj_object[_layer][num]=["",""];0
		gen_subject(_layer);
    }
}

function gen_subject(_layer){
    var tmp1="";
    var tmp2="";
    var x=1;
    if(pj_object[_layer][0] != undefined){
        delete pj_object[_layer][0];
    }
    $("#sj_box_"+_layer.toString()).html("");
    for(var i=1;i<=10;i++){
        if(pj_object[_layer][i] != undefined){
            $("#sj_box_"+_layer.toString()).append('<div><input required id="sj_name_'+_layer.toString()+'_'+i.toString()+'" type="text" value="'+pj_object[_layer][i][0]+'" placeholder="面相"><input required id="sj_dec_'+_layer.toString()+'_'+i.toString()+'" type="text" value="'+pj_object[_layer][i][1]+'" placeholder="面相說明"></div>');
        }
    }
}

function sj_load(_layer){
    var string1="", string2="", str="";
    for(var i =1;i<=10;i++){
        string1 = $('#sj_name_'+_layer.toString()+'_'+i).val();
        string2 = $('#sj_dec_'+_layer.toString()+'_'+i).val();
        if(string1 != undefined && string2 != undefined){
            str = str + "/" + string1 + ':' + string2;
        }
    }
    $('#sj_array_'+_layer.toString()).attr('value', str);
    return false;
}
