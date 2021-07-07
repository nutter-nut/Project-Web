var counter = 1;
var arr_row = [];

var local = document.getElementById("local");

$('#sectorSelect').change(function () {
    var id = $(this).val();
    var url = window.location.origin;

    if(local.value != 'th') var text = 'No data found';
    else var text = 'ไม่พบข้อมูล';

    $.ajax({
        url: url + "/admin/promotion/group/get_product/" + id,
        dataType: "json",
        success: function (data) {
            $('#subSectorSelect').empty();
            if(data.length > 0){
                $.each(data, function (key, value) {
                    $('#subSectorSelect').append('<option value="' + [value.prodCode, value.prodUnit1UOMCode, value.prodTName] + '" class="form-control">' + value.prodCode + '-' + value.prodTName + '</option>');
                });
                document.getElementById("btn_product_add").style.display = '';
            }else{
                $('#subSectorSelect').append('<option value="" class="form-control">'+ text +'</option>');
                document.getElementById("btn_product_add").style.display = 'none';
            }
        }
    });
});

async function addProductToArray(local)
{
    var str_product = $('#subSectorSelect').val();

    var data_product = str_product.split(",");

    var prod_code = data_product[0];
    var prod_uom = data_product[1];
    var prod_name = data_product[2];

    var data_uom = await getUom(prod_code);

    if(local != 'th') var text = 'remove';
    else var text = 'ลบ';

    arr_row.push(data_product);
    // console.log(arr_row);
    var arr_option = [];
    data_uom.forEach(element => {
        var str = "<option value='"+element.uomCode+"' class='form-control'>"+element.uomName+"</option>";
        arr_option.push(str);
    });

    var newdiv = document.createElement('div');
    newdiv.id = "dynamicInput["+counter+"]";

    newdiv.innerHTML = "<div class='row'><div class='col'><input type='hidden' name='prodCode["+counter+"]' id='prodCode' value='"+prod_code+"'><input type='text' class='form-control' value='"+prod_name+"' disabled></div><div class='col'><select name='uomCode["+counter+"]' class='form-control' id='uomCode' required>"+arr_option+"</select></div><div class='col'><button type='button' class='form-control remove-th btn btn-outline-danger' onClick='removeInput("+counter+");'>"+ text +"</button></div></div>"
    document.getElementById('dynamicField[0]').appendChild(newdiv);

    counter++;
}

function parseJSON(string){
    var result_of_parsing_json = JSON.parse(string);
    document.body.appendChild(
        document.createTextNode(result_of_parsing_json[0]["responseJSON"])
    );
} 

function removeInput(id)
{
    var id = "dynamicInput["+id+"]";
    var elem = document.getElementById(id);
    return elem.parentNode.removeChild(elem);
}

function getUom(id)
{
    var url = window.location.origin;
    return $.ajax({
        url: url + "/admin/stock/get_uomcode/" + id,
        dataType: "json",
    });
}

//------------------------------

var text_th = '//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json';
var text_en = '//cdn.datatables.net/plug-ins/1.10.24/i18n/English.json';
if(local.value != 'th') var text = text_en;
else var text = text_th;

$(document).ready(function () {
    $.noConflict();
    var table = $('#table_id').DataTable({
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [6] },
        ],
        "language": {
            "url": text
        }
    });
});