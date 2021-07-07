var max_default = 999;
var loop_i = document.getElementById("loop_i").value;
const products_cart = [];

for (i = 0; i < loop_i; i++) {
    var products_data = document.getElementById("data["+i+"]").value;
    var arr_products_data = products_data.split(",");

    var data = {};
    
    var prodCode = arr_products_data[1];
    var key = arr_products_data[1] + ',' + arr_products_data[2];
    var vat = arr_products_data[3];
    var type = arr_products_data[4];
    var max = arr_products_data[5];
    var ratio = arr_products_data[6];
    var qty = arr_products_data[7];

    data['prodCode'] = prodCode.replace(/[^0-9\.\,]+/g, "");
    data['price'] = arr_products_data[0];
    data['key'] = key.replace(/[^0-9\.\,]+/g, "");
    data['vat'] = vat.replace(/[^Y|N]+/g, "");
    data['type'] = type.replace(/[^Y|N]+/g, "");
    data['max'] = max.replace(/[^0-9\.\,]+/g, "");
    data['amount'] = qty.replace(/[^0-9\.\,]+/g, "");
    data['ratio'] = ratio.replace(/[^0-9\.\,]+/g, "");

    data['remaining'] = 0;
    data['qty'] = 0;

    products_cart.push(data);
  }

// console.log(products_cart);

function Update(key, value, index, element)
{    
    // console.log(key, value);
    for (var k = 0; k < products_cart.length; k++) {
        if (products_cart[k].prodCode == key) {
            if(value < 0){
                document.getElementById("qty["+index+"]").value = 1;
                document.getElementById("total_price["+index+"]").innerHTML = (1 * element.price).toFixed(2);
                document.getElementById("total_price2["+index+"]").value = (1 * element.price).toFixed(2);
                document.getElementById("total_price3").innerHTML = (1 * element.price).toFixed(2);
            }else{
                products_cart[k].remaining = value; 
            }
        }
    }
}


function stockResult(arr, qty, key, max)
{
    var prodCode = key.split(",");
    var product_max = max;
    var qty_all = 0;

    arr.forEach((element, index) => {
        if(element.prodCode === prodCode[0]){
            if(key === element.key){
                var product_qty = parseInt(qty);
                arr[index].amount = product_qty;
            }else{
                var product_qty = parseInt(element.amount);
            }

            qty_all = product_qty * parseInt(element.ratio);
            product_max = product_max - qty_all;

            Update(prodCode[0], product_max, key, element);
            
            arr[index].qty = product_qty;
        }
    });
    // console.log(arr);
}

function calProdUnitRatio_Uom(id, key)
{
    // console.log(id, key);

    var arr_ratio = id.split(",");
    var uom_code = arr_ratio[0];

    var ratio = parseInt(arr_ratio[1]);
    var price = parseInt(arr_ratio[2]);

    var vat = arr_ratio[3];
    var promotion = arr_ratio[4];
    var prod_code = arr_ratio[5];

    var type = arr_ratio[6];
    var max = parseInt(arr_ratio[7]);
    // var sum = price * qunatity;

    var qty = document.getElementById("qty["+key+"]").value;

    document.getElementById("total_uom_price["+key+"]").innerHTML = (1 * price).toFixed(0);

    document.getElementById("total_price["+key+"]").innerHTML = (qty * price).toFixed(2);

    document.getElementById("total_price2["+key+"]").value = (qty * price).toFixed(2);

    document.getElementById("add_more_item["+key+"]").value = prod_code+","+uom_code;

    updateSinglePrice();  

    btnSaveToCart();
}

function calProdUnitRatio(qty, price, key, vat, type, max, ratio) 
{
    if(qty > 0){ //n ติดลบไม่ได้
        var seleted_uom = document.getElementById("uomCode["+key+"]").value;
        var arr_ratio = seleted_uom.split(",");
        var price_uom = parseInt(arr_ratio[2]);

        if(type != 'Y'){
        
            if((parseInt(qty) * parseInt(ratio)) <= parseInt(max)){
                
                stockResult(products_cart, qty, key, max);

                document.getElementById("total_price["+key+"]").innerHTML = (qty * price_uom).toFixed(2);
                document.getElementById("total_price2["+key+"]").value = (qty * price_uom).toFixed(2);

                updateSinglePrice();
                //--

                document.getElementById("add_more").style.display = "";
                //--

                btnSaveToCart();
            }else{
                var result = Math.floor(parseInt(max) / parseInt(ratio));
                // console.log(result, parseInt(max), parseInt(ratio), parseInt(max) / parseInt(ratio));
                document.getElementById("qty["+key+"]").value = result;
                document.getElementById("total_price["+key+"]").innerHTML = (result * price_uom).toFixed(2);
                document.getElementById("total_price2["+key+"]").value = (result * price_uom).toFixed(2);
                document.getElementById("total_price3").innerHTML = (result * price_uom).toFixed(2);
            }
            // console.log(products_cart);
        }else{
            if(parseInt(qty) > 0 && (parseInt(qty) * parseInt(ratio)) <= max_default){

                stockResult(products_cart, qty, key, max_default);

                document.getElementById("total_price["+key+"]").innerHTML = (qty * price_uom).toFixed(2);
                document.getElementById("total_price2["+key+"]").value = (qty * price_uom).toFixed(2);

                updateSinglePrice();
                //--

                document.getElementById("add_more").style.display = "";
                //--

                btnSaveToCart();
                
            }else{
                var result = Math.floor(max_default / parseInt(ratio));
                document.getElementById("qty["+key+"]").value = result;
                document.getElementById("total_price["+key+"]").innerHTML = (result * price_uom).toFixed(2);
                document.getElementById("total_price2["+key+"]").value = (result * price_uom).toFixed(2);
                document.getElementById("total_price3").innerHTML = (result * price_uom).toFixed(2);
            }
        }
    }else{
        document.getElementById("qty["+key+"]").value = 1;
        document.getElementById("total_price["+key+"]").innerHTML = price.toFixed(2);
        document.getElementById("total_price2["+key+"]").value = price.toFixed(2);
        document.getElementById("total_price3").innerHTML = price.toFixed(2);
    }
}

function btnSaveToCart()
{
    var uomCode = document.getElementsByName("uomCode[]");
    var id_qty = $('input[name="id_qty[]"]');
    var arr_qty = [];
    id_qty.each(function (index, element) {
        var arr_uom_code = uomCode[index].value;
        var arr_ratio = arr_uom_code.split(",");
        arr_qty[index] = element.value+"-"+arr_ratio[0];
    });

    var arr_qty_mian = $('input[name="arr_qty_mian[]"]');
    var arr_qty_mian2 = [];
    arr_qty_mian.each(function (index, element) {
        arr_qty_mian2[index] = element.value;
    });

    if(arr_qty.toString() == arr_qty_mian2.toString()){
        document.getElementById("add_more").style.display = "none";
    }else{
        document.getElementById("add_more").style.display = "";
    }
}

function updateSinglePrice()
{
    var total_single_price = $('input[name="totalSinglePrice"]');
    var total  = 0;
    total_single_price.each(function (index, element) {
        total += Number(element.value);
    });

    document.getElementById("total_price3").innerHTML = (total).toFixed(2);
}


// function taxDeduction(vat, sum)
// {
//     if(vat == 'Y'){
//         var sum_price = sum + (sum * 0.07);
//         var int_part = Math.trunc(sum_price);
//         var float_part = Number((sum_price-int_part).toFixed(2));

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
