var local = document.getElementById("local");
var count = 0;
var i = 0

var text_no_data_en = 'No data found';
var text_no_data_th = 'ไม่พบข้อมูล';

if (local.value != 'th'){
    var text_no_data = text_no_data_en;
}
else{
    var text_no_data = text_no_data_th;
}

function removeInput(id){
    var id = "dynamicInput["+id+"]";
    var elem = document.getElementById(id);
    return elem.parentNode.removeChild(elem);
}

$('#prodGroupCode').change(function () {
    var id = $(this).val();
    var url = window.location.origin;
    $.ajax({
        url: url + "/admin/product/get_product_type/" + id,
        dataType: "json",
        success: function (data) {
            $('#ProdTypeCode').empty();
            if(data.length > 0){
                $.each(data, function (key, value) {
                    $('#ProdTypeCode').append('<option value="' + value.ProdTypeCode + '" class="form-control">' + value.ProdTypeName + '</option>');
                });
            }else{
                $('#ProdTypeCode').append('<option value="" class="form-control">'+ text_no_data +'</option>');
            }  
        }
    });
});

$(function () {
    $(":file").change(function () {
        if (this.files && this.files[0]) {
            count = this.files.length;
            // console.log(count);
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[i]);
            }
        }
    });
});

function imageIsLoaded(e) {
    var num = 100 / count;
    if (count > 4) {
        var x = $('#myImg').append("<img id='file_image[" + i + "]' src='" + e.target.result + "' class='img-circle img-fluid' style='width:25%;height:auto;padding:10px;border-radius:20px;'>");
    } else {
        var x = $('#myImg').append("<img id='file_image[" + i + "]' src='" + e.target.result + "' class='img-circle img-fluid' style='width:" + num + "%;height:auto;padding:10px;border-radius:20px;'>");
    }

    i++;
};

function checkFile() {
    for (var j = 0; j < i; j++) {
        var x = document.getElementById("file_image[" + j + "]");
        if (x) {
            x.remove(x.selectedIndex);
        }
    }
    i = 0;
}