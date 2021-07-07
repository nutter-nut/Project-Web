let header = [];

var local = document.getElementById("local");

var text_remove_en = 'Remove';
var text_enter_en = 'Enter';

var text_remove_th = 'ลบ';
var text_enter_th = 'กรอก';

if(local.value != 'th'){
    var text_remove = text_remove_en;
    var text_enter = text_enter_en;
}else{
    var text_remove = text_remove_th;
    var text_enter = text_enter_th;
} 

var head_edit = document.getElementById("head_edit").value;
var body_edit = document.getElementById("body_edit").value;

if(head_edit){
    var arr_head_edit = JSON.parse(head_edit);
    arr_head_edit.forEach((item) => { header.push(item) });
}

function addHeader() {
    var text = document.getElementById("add_header").value;
    
    header.push(text);
    if(body_edit != null){
        var arr_body_edit = JSON.parse(body_edit);
        // var last_head = Object.keys(arr_body_edit[0])[arr_body_edit.length];
        addTd(arr_body_edit.length, text);
    }

    document.getElementById("add_header").value = '';
    if(header) {
        var tr = '<th scope="col"><strong>'+text+'</strong><button type="button" id="'+header.length+'" class="btn btn-outline-danger remove-th float-right">'+text_remove+'</button></th>';
        $("#dynamicTable_h").append(tr);
    }
    $(document).on('click', '.remove-th', function(event){  
        $(this).parents('th').remove();
        var header_id = jQuery(this).attr("id");
        var name_header = header[header_id-1];

        if(body_edit != null){
            var arr_body_edit = JSON.parse(body_edit);
            removeColumnNew(arr_body_edit.length, name_header);
        }
        
        header.splice(header_id - 1, 1);
        removeA(header, header_id);
    }); 
}

function removeColumnNew(index, head){
    for (var k = 1; k <= index; k++) {
        var column_del = document.getElementById("addmore["+k+"]["+head+"]");
        column_del.remove();
    }
}

function addTd(index, head){
    for (var j = 1; j <= index; j++) {
        var td = '<td id="addmore['+j+']['+head+']"><input type="text" name="addmore['+j+']['+head+']" placeholder="'+text_enter+' '+head+'" class="form-control" required /></td>';
        var btn_del_exists = document.getElementById("btn_del_"+j);
        if(btn_del_exists){
            btn_del_exists.remove();
            var btn_del = '<td id="btn_del_'+j+'"><button type="button" class="btn btn-outline-danger" onclick="deleteRow(this)">'+text_remove+'</button></td>';
            $('#body_'+j).append(td, btn_del);
        }else{
            var btn_del = '<td id="btn_del_'+j+'"><button type="button" class="btn btn-outline-danger" onclick="deleteRow(this)">'+text_remove+'</button></td>';
            $('#body_'+j).append(td, btn_del);
        }
    }
}

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

var data_table_type = document.getElementById("data_table_type").value;
var num_row = 0;

if(data_table_type != 1){
    num_row = document.getElementById("num_row_edit").value * 1;
}

var i = num_row;

function Add() {
    if(isNaN(i)) return i = 0;
    ++i;

    let result = '';
    header.forEach(function(value, index) {
        var td = '<td><input type="text" name="addmore['+i+']['+value+']" placeholder="'+text_enter+' '+value+'" class="form-control" required /></td>';
        result += td;
    });
    $("#dynamicTable").append('<tr>'+result+'<td><button type="button" class="btn btn-outline-danger" onclick="deleteRow(this)">'+text_remove+'</button></td></tr>');
}

function upTo(el, tagName) {
    tagName = tagName.toLowerCase();

    while (el && el.parentNode) {
        el = el.parentNode;
        if (el.tagName && el.tagName.toLowerCase() == tagName) {
        return el;
        }
    }
    return null;
} 

function deleteRow(el) {
    var row = upTo(el, 'tr')
    if (row) row.parentNode.removeChild(row);
}

$(document).on('click', '.remove-th', function(event){  
    $(this).parents('th').remove();
    var header_id = jQuery(this).attr("id");
    var name_header = header[header_id-1];

    if(body_edit != null){
        var arr_body_edit = JSON.parse(body_edit);
        removeColumnNew(arr_body_edit.length, name_header);
    }
    
    header.splice(header_id - 1, 1);
    removeA(header, header_id);
}); 