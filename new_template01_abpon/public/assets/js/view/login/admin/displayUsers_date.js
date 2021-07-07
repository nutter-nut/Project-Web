var local = document.getElementById("local");

var day_th = [
    ["อา.","จ.","อ.","พ.","พฤ","ศ.","ส."],
    ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"]
]
var day_en = [
    ["Su","Mo","Tu","We","Th","Fr","Sa"],
    ["January","February","March","April","May","June","July","August","September","October","November","December"]
]

var btn_apply_th = "ตกลง";
var btn_apply_en = "Apply";

var btn_cancel_th = "ยกเลิก";
var btn_cancel_en = "Cancel";

var btn_clear_th = "ล้าง";
var btn_clear_en = "Clear";

if(local.value != 'th'){
    var day = day_en;
    var btn_apply = btn_apply_en;
    var btn_cancel = btn_cancel_en;
    var btn_clear = btn_clear_en;
}else{
    var day = day_th;
    var btn_apply = btn_apply_th;
    var btn_cancel = btn_cancel_th;
    var btn_clear = btn_clear_th;
} 

$('#date_ban').daterangepicker({
    "singleDatePicker": true,
    "autoUpdateInput": true,
    "locale": {
        "cancelLabel": btn_clear,
        "format": "YYYY-MM-DD",
        "applyLabel": btn_apply,
        "cancelLabel": btn_cancel,
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": day[0],
        "monthNames": day[1],
        "firstDay": 1
    },
    "linkedCalendars": true,
    "showCustomRangeLabel": false,
    "startDate": 1,
    // "endDate": "December 31, 2016 @ h:mm A",
    "opens": "center"
});
