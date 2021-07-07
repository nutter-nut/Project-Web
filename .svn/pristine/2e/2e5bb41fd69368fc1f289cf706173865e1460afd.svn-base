paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
        sandbox: 'AdHRVDF7a1_c1SP7wqNm-lx71sFkWB35iQLKjqukG0cfSR5ajFWqNyNbyaWx8P7tZMS0zBlHQiWlswiJ',
        production: 'demo_production_client_id'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
        size: 'medium',
        color: 'gold',
        shape: 'rect',
        label: 'paypal',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    payment: function(data, actions) {
        var total_price = document.getElementById("input_totalPrice").value;
        return actions.payment.create({
            transactions: [{
            amount: {
                // total: '{{ $totalPrice }}',
                total: total_price,
                currency: 'THB'
            }
            }]
        });
    },

    // Execute the payment
    onAuthorize: function(data, actions) {
        var full_name = document.getElementById("first").value +' '+ document.getElementById("last").value;
        var phone = document.getElementById("phone").value;
        var address = document.getElementById("address").value;
 
        return actions.payment.execute().then(function() {
            // Show a confirmation message to the buyer
            window.location = './paymentreceipt/' + data.paymentID + '/' + data.payerID  + '/' + full_name.b64encode() + '/' + phone.b64encode() + '/' + address.b64encode();
            // window.alert('Thank you for your purchase!');
        });
    }
}, '#paypal-button');

String.prototype.b64encode = function() { 
    return btoa(unescape(encodeURIComponent(this))); 
};
String.prototype.b64decode = function() { 
    return decodeURIComponent(escape(atob(this))); 
};

var currentValue = 0;

function handleClick(myRadio)
{

    var local = document.getElementById("local").value;
    // var local = 'th';
    var btn = document.getElementById("btnSubmit");

    var text_btn_pay_th = 'ไปหน้าชำระเงิน';
    var text_btn_pay_en = 'Place Order';
    var text_btn_qrcode_th = 'ไปหน้าสแกน QR Code';
    var text_btn_qrcode_en = 'Scan qrcode pagee';
    var text_btn_installment_th = 'ไปหน้าผ่อนชำระเงิน';
    var text_btn_installment_en = 'Place Order';

    if(local == 'th'){
        var text_btn_pay = text_btn_pay_th;
        var text_btn_qrcode = text_btn_qrcode_th;
        var text_btn_installment = text_btn_installment_th;
    }else{
        var text_btn_pay = text_btn_pay_en;
        var text_btn_qrcode = text_btn_qrcode_en;
        var text_btn_installment = text_btn_installment_en;
    }

    if(myRadio.value == 'paypal'){

        var first_name = document.forms["FormAddress"]["first_name"].value;
        var last_name = document.forms["FormAddress"]["last_name"].value;
        var phone = document.forms["FormAddress"]["phone"].value;
        var address = document.forms["FormAddress"]["address"].value;

        document.getElementById("message_store_form").style.display = "none"; 

        if (first_name == "" || last_name == "" || phone == "" || address == "")
        {
            alert("Not complete information");

            btn.style.display = "";
            btn.innerHTML = text_btn_pay;

            document.getElementById("moneyspace").checked = true;

            collapseType('moneyspace', btn, text_btn_pay);
            
        }else{

            btn.style.display = "none";

            document.getElementById("paypal-button").style.display = ""; 
            document.getElementById("message_store_form").style.display = "none"; 

            collapseType(myRadio.value, btn, text_btn_pay);
            
        }

    }else if(myRadio.value == 'credit_card'){

        btn.style.display = "";
        btn.innerHTML = text_btn_pay;

        document.getElementById("message_store_form").style.display = "none"; 
        
    }else if(myRadio.value == 'moneyspace'){

        collapseType(myRadio.value, btn, text_btn_pay);

    }else if(myRadio.value == 'qrcode'){
        
        collapseType(myRadio.value, btn, text_btn_qrcode);

    }else if(myRadio.value == 'installment'){

        collapseType(myRadio.value, btn, text_btn_installment);
        
    }else{
        console.log(myRadio.value);
    }
}

function addressSelete(value){
    var url = window.location.origin;
    if(value != "selete"){
        $.ajax({
            url: url + "/profile/address/edit/" + value,
            dataType: "json",
            success: function (data) {
                document.getElementById("first").value = data.first_name;
                document.getElementById("last").value = data.last_name;
                document.getElementById("phone").value = data.phone;
                document.getElementById("address").innerHTML = data.address;
            }
        });
    }else{
        document.getElementById("first").value = '';
        document.getElementById("last").value = '';
        document.getElementById("phone").value = '';
        document.getElementById("address").innerHTML = '';
    }
}

function collapseType(type, btn, text){
    if(type == 'moneyspace'){

        btn.style.display = "";
        btn.innerHTML = text;

        document.getElementById("paypal-button").style.display = "none";
        document.getElementById("message_store_form").style.display = ""; 

        document.getElementById('collapse_moneyspace').classList.add('show');
        document.getElementById('collapse_qrcode').classList.remove('show');
        document.getElementById('collapse_installment').classList.remove('show');
        document.getElementById('collapse_paypal').classList.remove('show');

        document.getElementById("installment_form").style.display = "none"; 


    }else if(type == 'qrcode'){

        btn.style.display = "";
        btn.innerHTML = text;

        document.getElementById("paypal-button").style.display = "none";
        document.getElementById("message_store_form").style.display = ""; 

        document.getElementById('collapse_moneyspace').classList.remove('show');
        document.getElementById('collapse_qrcode').classList.add('show');
        document.getElementById('collapse_installment').classList.remove('show');
        document.getElementById('collapse_paypal').classList.remove('show');

        document.getElementById("installment_form").style.display = "none"; 


    }else if(type == 'installment'){

        btn.style.display = "";
        btn.innerHTML = text;
        
        document.getElementById("paypal-button").style.display = "none";
        document.getElementById("message_store_form").style.display = ""; 

        document.getElementById('collapse_moneyspace').classList.remove('show');
        document.getElementById('collapse_qrcode').classList.remove('show');
        document.getElementById('collapse_installment').classList.add('show');
        document.getElementById('collapse_paypal').classList.remove('show');

        document.getElementById("installment_form").style.display = ""; 

    }else if(type == 'paypal'){

        document.getElementById('collapse_moneyspace').classList.remove('show');
        document.getElementById('collapse_qrcode').classList.remove('show');
        document.getElementById('collapse_installment').classList.remove('show');
        document.getElementById('collapse_paypal').classList.add('show');

        document.getElementById("installment_form").style.display = "none"; 

    }else{
        console.log(type);
    }
}

// function selectpromotion(value)
// {    
//     var arr_value = value.split(",");
//     var pomo_code = arr_value[0];
//     var disc_all_rate = arr_value[1];
//     var price = arr_value[2]; 

//     if(pomo_code != 'no')
//     {
//         var sum = ( price - ( price * ( disc_all_rate / 100 ) ) ) * 1.00;
//         var result = taxDeduction('Y', sum);

//         // console.log(price, disc_all_rate, sum, result);

//         document.getElementById("totalPrice").innerHTML = result + " บาท";
//         document.getElementById("input_totalPrice").value = result;

//     }else{

//         document.getElementById("totalPrice").innerHTML = price + " บาท";
//         document.getElementById("input_totalPrice").value = result;
//     }        
// }

// function taxDeduction(vat, sum)
// {
//     if(vat == 'Y')
//     {
//         var int_part = Math.trunc(sum);
//         var float_part = Number((sum-int_part).toFixed(2));

//         if(float_part < 0.88 ){
//             if(float_part < 0.63){
//                 if(float_part < 0.38){
//                     if(float_part < 0.13){
//                         var num = 0.00;
//                     }else var num = 0.25;
//                 }else var num = 0.50;
//             }else var num = 0.75;
//         }else var num = 1.00;

//         return int_part + num;

//     }else{
//         return (sum * 1.00).toFixed(2); 
//     }
// }