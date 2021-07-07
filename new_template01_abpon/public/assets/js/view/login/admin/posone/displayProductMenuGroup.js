var local = document.getElementById("local");

var text_th = '//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json';
var text_en = '//cdn.datatables.net/plug-ins/1.10.24/i18n/English.json';
if(local.value != 'th') var text = text_en;
else var text = text_th;

var set_name = '';

var countRow = document.getElementById("countRow").value //18
var keyRow = document.getElementById("keyRow").value; //10

if(keyRow < 10) var num = 0;
else var num = (~~(keyRow / 10) * 10);

$(document).ready(function () {
    $.noConflict();
    var table = $('#table_id').DataTable({
        "order": [[ 0, "asc" ]],
        "displayStart": num, //ถ้ารายการเลือก 10:item  จะเริ่มต้นที่หน้า 2
        "columnDefs": [
            { "orderable": false, "targets": [5] },
        ],
        "language": {
            "url": text
        }
    });

    // console.log(table.page.info());
});

function checkBoxReName()
{
    var checkbox_rename = document.querySelector('#new_code_cate:checked');
    var prodMenuGroupName = document.getElementById("prodMenuGroupName");

    if(checkbox_rename){
        set_name = prodMenuGroupName.value;
        prodMenuGroupName.value = '';
  
    }else prodMenuGroupName.value = set_name;
        
}

function checkBox()
{
    var checkbox = document.querySelector('#new_categorie:checked');
    var prodMenuGroupType = document.getElementById("prodMenuGroupType");

    if(checkbox){
        prodMenuGroupType.setAttribute("disabled", "");

        document.getElementById("form_menuname_muti").style.display = "";
        document.getElementById("form_menuname").style.display = "none";

        document.getElementById("prodMenuGroupName").required = false;

        document.getElementById("prodMenuGroupName1").required = true;
        document.getElementById("prodMenuGroupName2").required = true;
        document.getElementById("prodMenuGroupName3").required = true;
        document.getElementById("prodMenuGroupName4").required = true;
        
    }else{
        prodMenuGroupType.removeAttribute("disabled", "");

        document.getElementById("form_menuname_muti").style.display = "none";
        document.getElementById("form_menuname").style.display = "";

        document.getElementById("prodMenuGroupName").required = true;

        document.getElementById("prodMenuGroupName1").required = false;
        document.getElementById("prodMenuGroupName2").required = false;
        document.getElementById("prodMenuGroupName3").required = false;
        document.getElementById("prodMenuGroupName4").required = false;
    }
}

function changeMenuGroup(value)
{
    var arrCode = value.split("_");
    var count = arrCode.length;

    if(count == 4 || count == 3)document.getElementById("form_image").style.display = "none";
    else document.getElementById("form_image").style.display = "";
}