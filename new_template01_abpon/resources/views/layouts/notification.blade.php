@if(Auth::check() && Auth::user()->isAdmin())

<input type="hidden" id="local" value="{{ \Session::get('locale') }}">

<input type="hidden" id="user_id" value="{{ Auth::user()->id }}">

<link rel="stylesheet" href="{{URL::asset('assets/dist/notifications.css')}} ">

<script src="{{ asset('assets/dist/notifications.js') }}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>

// Pusher.logToConsole = true;
var local = document.getElementById("local").value;

var user_id = document.getElementById("user_id").value;

var pusher = new Pusher('590568f01b3f8bbebe8e', {
    cluster: 'ap1'
});

var channel = pusher.subscribe('log-activity'); 

channel.bind('LogActivity', function(data) { 
    if(data.user_id != user_id){
        const myNotification = window.createNotification({
            closeOnClick: true, // close on click
            displayCloseButton: false, // displays close button
            positionClass: 'nfc-top-right', // nfc-top-left, nfc-bottom-right, nfc-bottom-left
            onclick: false, // callback
            showDuration: 12000, // timeout in milliseconds
            theme: data.type // success, info, warning, error, and none
        });
    
        myNotification({ 
            title: '' + data.user_name + '',
            message: data.description[local]
        });
    
        var arr_date = data.now.split(" ");
        var arr_date2 = arr_date[0].split("-");
    
        var new_date = arr_date2[2] + ' ' + getMonth(arr_date2[1]) + ' ' + arr_date2[0] + ' ' + arr_date[1];
    
        $(document).ready(function() {
            var table = $('#table_id_dashboard').DataTable();
    
            var row_data1 = "<tr><td class='sorting_1'>"+data.id+"</td></tr>";
    
            var row_data2 = "<tr role='row' class='odd'><td><a><div class='btn btn-"+getType(data.type)+" btn-circle'><i class='"+data.icon+"'></i></div><div class='mail-contnet'><h5>"+data.description[local]+"</h5> <span class='mail-desc'>"+data.user_name+"</span></div></a></td></tr>";
    
            var row_data3 = "<tr><td class='sorting_1'><span class='time'>"+new_date+"</span></td></tr>";
            
            table.row.add([
                row_data1,
                row_data2,
                row_data3,
            ]).draw(false);
    
        });
    }
});

function getType(type){
    var type2;
    switch(type) {
    case 'success':
        type2 = 'success';
        break;
    case 'info':
        type2 = 'info';
        break;
    case 'warning':
        type2 = 'warning';
        break;
    case 'error':
        type2 = 'danger';
        break;
    default:
        type2 = 'primary';
    }
    return type2;
}

function getMonth(month){
    var month2;
    switch(month) {
    case '01':
        month2 = 'ม.ค.';
        break;
    case '02':
        month2 = 'ก.พ.';
        break;
    case '03':
        month2 = 'มี.ค.';
        break;
    case '04':
        month2 = 'เม.ย.';
        break;
    case '05':
        month2 = 'พ.ค.';
        break;
    case '06':
        month2 = 'มิ.ย.';
        break;
    case '07':
        month2 = 'ก.ค.';
        break;
    case '08':
        month2 = 'ส.ค.';
        break;
    case '09':
        month2 = 'ก.ย.';
        break;
    case '10':
        month2 = 'ต.ค.';
        break;
    case '11':
        month2 = 'พ.ย.';
        break;
    case '12':
        month2 = 'ธ.ค.';
        break;
    }
    return month2;
}

</script>

@endif