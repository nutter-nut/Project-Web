let header = [];
        
function addHeader() {
    var text = document.getElementById("add_header").value;
    header.push(text);
    document.getElementById("add_header").value = '';
    if(header) {
        var tr = '<th>'+text+'<button type="button" id="'+text+'" class="btn btn-danger remove-th float-right">Remove</button></th>'
        $("#dynamicTable").append(tr);
    }
    $(document).on('click', '.remove-th', function(event){  
        $(this).parents('th').remove();
        var name_header = jQuery(this).attr("id");
        removeA(header, name_header);
    }); 
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

var i = 0;
function Add() { 
    ++i;
    let result = '';
    header.forEach(function(value, index) {
        var td = '<td><input type="text" name="addmore['+i+']['+value+']" placeholder="Enter '+value+'" class="form-control" /></td>';
        result += td;
    });
    $("#dynamicTable").append('<tr>'+result+'<td><button type="button" class="btn btn-danger" onclick="deleteRow(this)" >Remove</button></td></tr>');
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