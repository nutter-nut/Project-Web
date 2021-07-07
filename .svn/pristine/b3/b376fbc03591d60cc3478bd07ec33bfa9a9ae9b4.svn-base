var local = document.getElementById("local");

var text_th = '//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json';
var text_en = '//cdn.datatables.net/plug-ins/1.10.24/i18n/English.json';
if (local.value != 'th') var text = text_en;
else var text = text_th;

$(document).ready(function() {
    $.noConflict();
    var table = $('#table_id_dashboard').DataTable({
        "order": [
            [0, "desc"]
        ],
        "columnDefs": [
            { "orderable": false, "targets": [1, 2] },
        ],
        "language": {
            "url": text
        },
        "lengthMenu": [[10, 20, 50], [10, 20, 50]]
    });
});