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
    if(pj_object[_layer].length<=10){
        pj_object[_layer][pj_object[_layer].length]=["",""];
        $("#sj_box_" + _layer.toString()).html("");
		gen_subject(_layer);
    }
}

function gen_subject(_layer){
    var tmp1="";
    var tmp2="";
    var x=1;
    for(var i=1;i<=10;i++){
        if(pj_object[_layer][i] != undefined){
            for (const [key,value] of Object.entries(pj_object[_layer][i])) {
                $("#sj_box_"+_layer.toString()).append('');
            }
        }
    }
}