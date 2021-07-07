var local = document.getElementById("local");

var text_th = '//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json';
var text_en = '//cdn.datatables.net/plug-ins/1.10.24/i18n/English.json';
if(local.value != 'th') var text = text_en;
else var text = text_th;

$(document).ready(function () {
    $.noConflict();
    var table = $('#table_id').DataTable({
        "order": [[ 3, "asc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [5] },
        ],
        "language": {
            "url": text
        }
    });
});
    
$('#sectorSelect').change(function () {
    var id = $(this).val();
    var url = window.location.origin;
    $.ajax({
        url: url + "/admin/stock/get_uomcode/" + id,
        dataType: "json",
        success: function (data) {
            $('#subSectorSelect').empty();
            $.each(data, function (key, value) {
                $('#subSectorSelect').append('<option value="' + [value.uomCode, value.prodUnitRatio] + '" class="form-control">' + value.uomName + '</option>');
            });
        }
    });
});

// function sectorSelectUomName() {
//     var x = document.getElementById("sectorSelectUomName").value;
//     // document.getElementById("demo").innerHTML = "You selected: " + x;
//     console.log(x);
// }