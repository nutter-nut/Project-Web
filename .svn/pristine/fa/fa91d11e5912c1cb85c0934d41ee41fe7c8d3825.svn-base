var local = document.getElementById("local");

var text_th = '//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json';
var text_en = '//cdn.datatables.net/plug-ins/1.10.24/i18n/English.json';

var text_no_data_en = 'No data found';
var text_no_data_th = 'ไม่พบข้อมูล';

if (local.value != 'th'){
    var text = text_en;
    var text_no_data = text_no_data_en;
}
else{
    var text = text_th;
    var text_no_data = text_no_data_th;
}

$(document).ready(function() {
    $.noConflict();
    var table = $('#table_id').DataTable({
        "order": [
            [8, "desc"]
        ],
        "columnDefs": [
            { "orderable": false, "targets": [10] },
        ],
        "language": {
            "url": text
        }
    });
});
