var local = document.getElementById("local");

var text_th = '//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json';
var text_en = '//cdn.datatables.net/plug-ins/1.10.24/i18n/English.json';
if(local.value != 'th') var text = text_en;
else var text = text_th;

var countRow = document.getElementById("countRow").value;
var keyRow = countRow - document.getElementById("keyRow").value;

if(keyRow < 10) var num = 0;
else var num = (~~((keyRow - 1) / 10) * 10);

$(document).ready(function () {
    $.noConflict();
    var table = $('#table_id').DataTable({
        "displayStart": num,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [3] },
        ],
        "language": {
            "url": text
        }
    });
});