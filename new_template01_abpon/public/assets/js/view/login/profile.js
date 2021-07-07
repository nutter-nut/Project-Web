var local = document.getElementById("local");

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

function addressEdit(id){
    var url = window.location.origin;
    $.ajax({
        url: url + "/profile/address/edit/" + id,
        dataType: "json",
        success: function (data) {
            $("input[name='id_edit']").val(data.id);
            $("input[name='place_name_edit']").val(data.place_name);
            $("input[name='first_name_edit']").val(data.first_name);
            $("input[name='last_name_edit']").val(data.last_name);
            $("input[name='phone_edit']").val(data.phone);
            $("input[name='address_edit']").val(data.address);

            $("#address_edit").modal();
        }
    });
}