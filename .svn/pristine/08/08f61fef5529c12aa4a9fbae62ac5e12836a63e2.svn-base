var counter = 1;
var local = document.getElementById("local");

var text_sure_en = 'Are you sure?';
var text_del_en = 'remove';
var text_no_data_en = 'No data found';

var text_sure_th = 'คุณแน่ใจที่จะลบ';
var text_del_th = 'ลบ';
var text_no_data_th = 'ไม่พบข้อมูล';

if(local.value != 'th'){
    var text_sure = text_sure_en;
    var text_del = text_del_en;
    var text_no_data = text_no_data_en;
}else{
    var text_sure = text_sure_th;
    var text_del = text_del_th;
    var text_no_data = text_no_data_th;
}

function addInput(local) {
    var newdiv = document.createElement('div');

    newdiv.id = "dynamicInput["+counter+"]";

    newdiv.innerHTML = "<div id='dynamicField["+counter+"]'><div class='row pt-3'><div class='col'><select name='uomCode[]' class='form-control' id='uomCode' required>@foreach ($get_uom as $item)<option value='{{ $item->uomCode }}' class='form-control'>{{ $item->uomName }}</option>@endforeach</select></div><div class='col'><input type='number' class='form-control' name='prodUnitRatio[]' id='prodUnitRatio' placeholder='' required></div><div class='col'><input type='number' class='form-control' name='prodUnitPrice[]' id='prodUnitPrice' placeholder='' required></div><div class='col'><button type='button' class='form-control remove-th btn btn-outline-danger' onClick='removeInput("+counter+");'>"+ text_del +"</button></div></div></div>"
    document.getElementById('dynamicFieldEdit[0]').appendChild(newdiv);

    counter++;
}

function removeInputMain(id){
    var result = confirm(text_sure);
    if (result) {
        document.getElementById("dynamicField["+id+"]").remove();
    }
} 

function removeInput(id){
    var id = "dynamicInput["+id+"]";
    var elem = document.getElementById(id);
    return elem.parentNode.removeChild(elem);
} 

$('#prodGroupName').change(function () {
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