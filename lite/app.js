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