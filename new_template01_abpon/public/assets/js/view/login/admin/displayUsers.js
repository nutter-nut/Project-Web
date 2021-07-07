var local = document.getElementById("local");

var text_th = '//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json';
var text_en = '//cdn.datatables.net/plug-ins/1.10.24/i18n/English.json';

var url = window.location.origin;
var url_user = url + "/admin/user/update";
var url_employee = url + "/admin/user/update/posone";
var text_no_data_en = 'No data found';
var text_no_data_th = 'ไม่พบข้อมูล';

var date_chat_en = 'en-US';
var date_chat_th = 'th-TH';

var btn_add_en = 'add';
var btn_add_th = 'เพิ่ม';
var btn_del_en = 'Delete';
var btn_del_th = 'ลบ';
var chat_history_en = 'Chat history';
var chat_history_th = 'ประวัติการแชท';
var text_cf_en = 'Are you sure?';
var text_cf_th = 'คุณแน่ใจที่จะลบ';

var load = 1;
var this_session;
var this_id2;

if(local.value != 'th'){
    var text = text_en;
    var text_no_data = text_no_data_en;
    var btn_add = btn_add_en;
    var btn_del = btn_del_en;
    var chat_histor = chat_history_en;
    var text_cf = text_cf_en;
    var date_chat = date_chat_en;
}else{
    var text = text_th;
    var text_no_data = text_no_data_th;
    var btn_add = btn_add_th;
    var btn_del = btn_del_th;
    var chat_histor = chat_history_th;
    var text_cf = text_cf_th;
    var date_chat = date_chat_th;
} 

$(document).ready(function () {
    $.noConflict();
    var table = $('#table_id').DataTable({
        "order": [[ 1, "desc" ], [ 0, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [6] },
        ],
        "language": {
            "url": text
        }
    });
});

function seleteInsertType(value){
    var url = window.location.origin;
    var url_user = url + "/admin/user/insert";
    var url_employee = url + "/admin/user/insert/posone";

    if(value != '0'){
        document.getElementById("insert_to_posone").style.display = '';
        document.getElementById("employee_select_sub").style.display = '';
        document.getElementById("insert_form").action = url_employee; 
    }else{
        document.getElementById("insert_to_posone").style.display = 'none';
        document.getElementById("employee_select_sub").style.display = 'none';
        document.getElementById("insert_form").action = url_user; 
    }
}

function handleScroll(){
    var elmnt = document.getElementById("box_chat");
    var ul = document.getElementById("chat_massge");
    var y = elmnt.scrollTop;

    if(y == 0){
        load++;
        getMeassge(this_session, this_id2, load, ul, elmnt, 2);
    }
}

function userChat(id){
    document.getElementById("getFriendList").innerHTML = "";
    document.getElementById("chat_massge").innerHTML = "";
    document.getElementById("getUserAll").innerHTML = "";
    getFriendList(id);
    getUserAll(id);
}

function getUserAll(id){
    $.ajax({
        url: url + "/admin/get/user_all/" + id,
        dataType: "json",
        success: function (data) {

            var getUserAll = document.getElementById("getUserAll");
            var ul = document.createElement('ul');
            
            ul.setAttribute('id','proList');
            ul.setAttribute('style','padding: 20px;');

            getUserAll.appendChild(ul);
            data.forEach(renderProductList);

            function renderProductList(element, index, arr) {
                var li = document.createElement('li');
                li.setAttribute('class','item text-truncate');

                ul.appendChild(li);

                var image = "<img class='pic-1' style='height:35px;width:35px;border-radius:50%;' src='"+url+"/storage/user_images/"+element.image+"'>"
                var add_session = "<a class='btn btn-outline-success btn-sm' href='#' role='button' onclick='addSession("+element.id+","+id+")'>"+btn_add+"</a>";

                li.innerHTML = li.innerHTML + '<div class="text-chat-username">' + image + ' ' + element.name + ' <b>'+ element.email +'</b></div><div class="float-right">'+add_session+'</div><hr>';
            }
        }
    });
    }

function getFriendList(id){
    $.ajax({
        url: url + "/admin/get/friends_list/" + id,
        dataType: "json",
        success: function (data) {
            var getFriendList = document.getElementById("getFriendList");
            var ul = document.createElement('ul');

            if(data.length == 0) getFriendList.innerHTML = text_no_data;
            
            ul.setAttribute('id','proList');
            ul.setAttribute('style','padding: 20px;');

            getFriendList.appendChild(ul);
            data.forEach(renderProductList);

            function renderProductList(element, index, arr) {
                var li = document.createElement('li');
                li.setAttribute('class','item text-truncate');

                ul.appendChild(li);

                var image = "<img class='pic-1' style='height:35px;width:35px;border-radius:50%;' src='"+url+"/storage/user_images/"+element.image+"'>"

                var view_chat = "<a class='btn btn-outline-info btn-sm' href='#' role='button' onclick='viewChat("+element.session+","+element.id+","+id+")'>"+chat_histor+"</a>";
                var del_session = "<a class='btn btn-outline-danger btn-sm' href='#' role='button' onclick='delSession("+element.session+","+id+")'>"+btn_del+"</a>";

                li.innerHTML = li.innerHTML + '<div class="text-chat-username">' + image + ' ' + element.name + ' <b>'+ element.email +'</b></div><div class="float-right">'+view_chat+del_session+'</div><hr>';
            }
        }
    });
}

function addSession(f_id, this_id){
    $.ajax({
        url: url + "/admin/add/session",
        data: { f_id: f_id, this_id : this_id} ,
        dataType: "json",
        success: function (data) {
            if(data[0]){
                userChat(this_id);
            }
        }
    });
}

function delSession(session, id){
    var cf = confirm(text_cf);
    if (cf){
        $.ajax({
            url: url + "/admin/del/session",
            data: { session: session } ,
            dataType: "json",
            success: function (data) {
                if(data == 1){
                    userChat(id);
                }
            }
        });
    }
    else return false;
}

function viewChat(session, f_id, this_id){
    var ul = document.getElementById("chat_massge");
    var elmnt = document.getElementById("box_chat");

    ul.innerHTML = "";
    this_session = "";
    this_id2 = "";
    load = 1;

    getMeassge(session, this_id, load, ul, elmnt, 1);
}

function getMeassge(session, this_id, load, ul, elmnt, type){
    this_session = session;
    this_id2 = this_id;
    $.ajax({
        url: url + "/admin/get/messages",
        dataType: "json",
        data : { session: session, load: load, type: 2 },
        success: function (data) {

            if(data.length == 0) ul.innerHTML = text_no_data;

            if(data != 0){
                data.forEach(element => {
                    if(this_id == element.user_id){
                        var chat_class = "chat-right";
                        chatLists(chat_class, element, ul, type);
                    }else{
                        var chat_class = "chat-left";
                        chatLists(chat_class, element, ul, type);
                    }
                });
                if(load == 1) elmnt.scrollTop = elmnt.scrollHeight;
            }else{
                console.log('No message');
            }

        }
    });
}

function chatLists(text, element, ul, type){
    var li = document.createElement("li");

    li.classList.add(text);

    var div_avatar = document.createElement('div')
    div_avatar.classList.add('chat-avatar');
    
    const img = document.createElement("img");
    img.src = url + "/storage/user_images/" + element.image;
    div_avatar.appendChild(img);

    var div_img = document.createElement('div');
    div_img.classList.add('chat-name');
    div_img.appendChild(document.createTextNode(element.name));
    div_avatar.appendChild(div_img);

    if(element.status == 2){
        var image2 = "<img class='pic-1 img-fluid' style='height:auto;width:100px;' src='"+url+"/storage/message_images/"+element.message+"'>"
        var div_text = document.createElement('div');
        div_text.classList.add('chat-text');
        div_text.innerHTML = image2;
    }else if(element.status == 1){
        var div_text = document.createElement('div');
        div_text.classList.add('chat-text');
        div_text.appendChild(document.createTextNode(element.message));
    }else{
        console.log(element.message);
    }

    var time = formetTime(element.created_at);

    var div_time = document.createElement('div');
    div_time.classList.add('chat-hour');
    div_time.appendChild(document.createTextNode(time));

    if(text == "chat-left"){
        li.appendChild(div_avatar);
        li.appendChild(div_text);
        li.appendChild(div_time);
    }else{
        li.appendChild(div_time);
        li.appendChild(div_text);
        li.appendChild(div_avatar);
    }

    if(type == 1) ul.appendChild(li);
    else ul.prepend(li);
}

function formetTime(value){
    var time = value;
    var arr_time = time.split(" ");
    var arr_time2 = arr_time[0].split("-");

    const date = new Date(arr_time2[0] * 1, (arr_time2[1] * 1) - 1, arr_time2[2] * 1)
    const result = date.toLocaleDateString(date_chat, {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long',
    });

    return result;
}

function userBan(id){
    var url_action = url + "/admin/user/suspend/" + id;

    document.getElementById("ban_form").action = url_action; 

    $.ajax({
        url: url + "/admin/user/data/" + id,
        dataType: "json",
        success: function (data) {
            if(data.banned_until != "1") $("input[name='date_ban']").val(data.banned_until);
        }
    });
}

function userEdit(id){
    $.ajax({
        url: url + "/admin/user/data/" + id,
        dataType: "json",
        success: function (data) {
            // console.log(data);
            $("input[name='username']").val(data.name);
            $("input[name='email']").val(data.email);
            $("input[name='user_id']").val(data.id);

            if(data.admin == 1){
                document.getElementById("is_admin_edit").checked = true;
            } else document.getElementById("is_admin_edit").checked = false;
            if(data.sale == 1){
                document.getElementById("is_sale_edit").checked = true;
            } else document.getElementById("is_sale_edit").checked = false;
            if(data.employee == '0'){
                document.getElementById("edit_to_posone").style.display = 'none';
                document.getElementById("edit_type").options.selectedIndex = '0';
                document.getElementById("edit_form").action = url_user;
                document.getElementById("register_type").style.display = 'none';

                prefixEdit(data.prefix, 'prefix_edit');
                $("input[name='first_name_edit']").val(data.first_name);
                $("input[name='last_name_edit']").val(data.last_name);

                $("input[name='nick_name_edit']").val('');
                $("input[name='citizenid_edit']").val('');
                $("input[name='phone_number_edit']").val(data.tel);
                statusCheck('single');
                document.getElementById("address_edit").value = '';
            }
            else{
                document.getElementById("edit_to_posone").style.display = '';
                document.getElementById("edit_type").options.selectedIndex = '1';
                document.getElementById("edit_form").action = url_employee;
                document.getElementById("register_type").style.display = 'none';
                getUserInPosone(data.employee);
            }
            
            resetPasswordHide();
                
            document.getElementById("blah_edit").src = window.location.origin + "/storage/user_images/" + data.image;

            $("#user_edit").modal();
        }
    });
}

function getUserInPosone(empCode)
{
    $.ajax({
        url: url + "/admin/get_user/posone/" + empCode,
        dataType: "json",
        success: function (data) {
            var key = Object.keys(data)[0];
            value = data[key];

            var empPOSName = value.empPOSName;
            var arr_empPOSName = empPOSName.split("-");

            var empPOSReferName = value.empPOSReferName;
            var arr_empPOSReferName = empPOSReferName.split("-");

            prefixEdit(arr_empPOSName[0], 'prefix_edit');
            prefixEdit(arr_empPOSReferName[0], 'refer_prefix_edit');

            $("input[name='first_name_edit']").val(arr_empPOSName[1]);
            $("input[name='last_name_edit']").val(arr_empPOSName[2]);

            $("input[name='refer_first_name_edit']").val(arr_empPOSReferName[1]);
            $("input[name='refer_last_name_edit']").val(value.empPOSReferSurName);

            $("input[name='nick_name_edit']").val(value.empPOSNickName);

            var empPOSPeopleId = fotmatInput(value.empPOSPeopleId, [2,6,11,12]); // "_-____-_____-_-__"
            $("input[name='citizenid_edit']").val(empPOSPeopleId);

            var empPOSTaxId_edit = fotmatInput(value.empPOSTaxId, [2,6,11,12]); // "_-____-_____-_-__"
            $("input[name='empPOSTaxId_edit']").val(empPOSTaxId_edit);

            var empPOSTel = fotmatInput(value.empPOSTel, [3,6]); // __-____-____ 
            $("input[name='phone_number_edit']").val(empPOSTel);

            statusCheck(value.empPOSMaritalStatus);

            document.getElementById("address_edit").value = value.empPOSAddress;
            document.getElementById("refer_address_edit").value = value.empPOSReferAddress;
        }
    });
}

function statusCheck(status){
    if(status == 'single'){
        document.getElementById("status1_edit").checked = true;
    }else if(status == 'married'){
        document.getElementById("status2_edit").checked = true;
    }else if(status == 'divorce'){
        document.getElementById("status3_edit").checked = true;
    }else{
        document.getElementById("status4_edit").checked = true;
    }
}

function prefixEdit(prefix, where_id){
    if(prefix == 'นาย' || prefix == 'mr'){
        document.getElementById(where_id).selectedIndex = '0';
    }else if(prefix == 'นางสาว' || prefix == 'ms'){
        document.getElementById(where_id).selectedIndex = '1';
    }else if(prefix == 'นาง' || prefix == 'mrs'){
        document.getElementById(where_id).selectedIndex = '2';
    }else{
        console.log('prefix error.');
        document.getElementById(where_id).selectedIndex = '0';
    }
}

function resetPassword(type){
    if(type){
        document.getElementById("resetpassword").style.display = '';
        document.getElementById("resetpassword_hide").style.display = '';
        document.getElementById("resetpassword_muted").style.display = 'none';
        document.getElementById("password_status").value = 1;
    }else{
        document.getElementById("resetpassword").style.display = '';
        // document.getElementById("resetpassword_hide").style.display = '';
        document.getElementById("resetpassword_muted").style.display = 'none';
        document.getElementById("password_status").value = 1;
    }
}

function resetPasswordHide(){
    document.getElementById("resetpassword").style.display = 'none';
    document.getElementById("resetpassword_hide").style.display = 'none';
    document.getElementById("resetpassword_muted").style.display = '';
    document.getElementById("password_status").value = 0;
}

function seleteEditType(value){
    var username = document.getElementById("username").value; 
    
    if(value != '0'){
        document.getElementById("edit_to_posone").style.display = '';
        document.getElementById("employee_select_edit_sub").style.display = '';
        document.getElementById("edit_form").action = url_employee; 
        $.ajax({
            // url: url + "/admin/user/user_check2/posone/" + username,
            url: url + "/admin/get_user/posone/" + username,
            dataType: "json",
            success: function (data) {
                var key = Object.keys(data)[0];
                value = data[key];
                if(typeof(value) != 'undefined'){
                    console.log(value);
                    if(value.status == 'D'){
                        // resetPassword(0);
                        // document.getElementById("hire").checked = true;
                        // document.getElementById("register_type").style.display = '';
                        // document.getElementById("edit_to_posone").style.display = 'none';

                        var empPOSPeopleId = fotmatInput(value.empPOSPeopleId, [2,6,11,12]);
                        var empPOSTaxId_edit = fotmatInput(value.empPOSTaxId, [2,6,11,12]); // "_-____-_____-_-__"
                        var empPOSTel = fotmatInput(value.empPOSTel, [3,6]); // __-____-____ 
                        var empPOSReferName = value.empPOSReferName;
                        var arr_empPOSReferName = empPOSReferName.split("-");
                        
                        $("input[name='nick_name_edit']").val(value.empPOSNickName);
                        $("input[name='citizenid_edit']").val(empPOSPeopleId);
                        $("input[name='empPOSTaxId_edit']").val(empPOSTaxId_edit);
                        $("input[name='phone_number_edit']").val(empPOSTel);

                        statusCheck(value.empPOSMaritalStatus);
                        prefixEdit(arr_empPOSReferName[0], 'refer_prefix_edit');

                        document.getElementById("address_edit").value = value.empPOSAddress;
                        document.getElementById("refer_address_edit").value = value.empPOSReferAddress;

                        $("input[name='refer_first_name_edit']").val(arr_empPOSReferName[1]);
                        $("input[name='refer_last_name_edit']").val(value.empPOSReferSurName);

                        // resetPasswordHide();
                        resetPassword();
                    }else{
                        resetPasswordHide();
                    }
                }else{
                    resetPassword(0);
                }
            }
        });
    }else{
        document.getElementById("edit_to_posone").style.display = 'none';
        document.getElementById("employee_select_edit_sub").style.display = 'none';
        document.getElementById("edit_form").action = url_user;
        resetPasswordHide();
    }
}

function userInsert(){
    $("input[name='username']").val('');
    $("input[name='email']").val('');
    $("input[name='password']").val('');
}

function registerType(value){
    if(value != '1'){
        document.getElementById("edit_to_posone").style.display = '';
        resetPassword(0);
    }else{
        document.getElementById("edit_to_posone").style.display = 'none';
        resetPasswordHide();
    }
}

function fotmatInput(value, fotmat){
    var text = '';
    var arr_value = value.split("");
    var i = 1;

    arr_value.forEach(function(element) {
        fotmat.forEach((element2) => { if(element2 == i) text += '-'; } );
        text += element;
        i++;
    });

    return text;
}

function formSubmit(form_name) {
    if(form_name == 'insert_form') document.getElementById('insert_form').submit();
    else document.getElementById('edit_form').submit();
}