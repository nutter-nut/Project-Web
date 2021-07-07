var local = document.getElementById("local");

function eventDiscountPer(value) {
    var num = value
    if(num){
        if(num < 1 || num > 100){
            document.getElementById("discount_per").value = 1;
            document.getElementById("discount_per").innerHTML = 1;
            document.getElementById("discount").disabled = true;
        }else{
            document.getElementById("discount").disabled = true;
        }
    }else{
        document.getElementById("discount").disabled = false;
    }
}

var text_th = '//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json';
var text_en = '//cdn.datatables.net/plug-ins/1.10.24/i18n/English.json';
if(local.value != 'th') var text = text_en;
else var text = text_th;

$(document).ready(function () {
    $.noConflict();
    var table = $('#table_id').DataTable({
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [8] },
        ],
        "language": {
            "url": text
        }
    });
});

// function eventDiscount(value) {
//     var num = value
//     if(num){
//         if(num < 1){
//             document.getElementById("discount").value = 1;
//             document.getElementById("discount").innerHTML = 1;
//             document.getElementById("discount_per").disabled = true;
//         }else{
//             document.getElementById("discount_per").disabled = true;
//         }
//     }else{
//         document.getElementById("discount_per").disabled = false;
//     }
// }