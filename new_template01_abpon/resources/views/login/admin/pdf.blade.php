<table class="wrap-box" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width: 60%;"><span class="header-title">{{ $data['company_name'] }}</span>
            <br /> {{$data['address']}}
            <br /> เลขที่ประจำตัวผู้เสียภาษี {{$data['tax_no']}}
        </td>
        <td style="text-align: right;width: 40%;"><span class="header-title">ใบกำกับภาษี/ใบเสร็จรับเงิน</span><br/>{{ $data['source'] }}</td>
    </tr>
</table>
<div class="line"></div>
<table class="wrap-box line-top" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:70%;">
            <table class="wrap-top" cellpadding="3" cellspacing="0">
                <tr>
                    <td style="width:15%;"><b>รหัสลูกค้า</b></td>
                    <td style="width:85%;">{{$date_customer['code']}}</td>
                </tr>
                <tr>
                    <td><b>ชื่อลูกค้า</b></td>
                    <td>{{$date_customer['name']}}</td>
                </tr>
                <tr>
                    <td><b>ที่อยู่</b></td>
                    <td>{{$date_customer['address']}}</td>
                </tr>
                <tr>
                    <td><b>เบอร์โทร</b></td>
                    <td>{{$date_customer['tel']}}</td>
                </tr>
                <tr>
                    <td colspan="2"><b>เลขประจำตัวผู้เสียภาษี</b> {{$date_customer['tax_no']}}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="wrap-top" cellpadding="3" cellspacing="0">
                <tr>
                    <td style="width:25%;"><b>เลขที่เอกสาร</b></td>
                    <td style="width:75%;">{{$date_customer['doc_no']}}</td>
                </tr>
                <tr>
                    <td><b>วันที่เอกสาร</b></td>
                    <td>{{$date_customer['doc_date']}}</td>
                </tr>
                <tr>
                    <td><b>วันที่ครบกำหนด</b></td>
                    <td>{{$date_customer['due_date']}}</td>
                </tr>
                <tr>
                    <td><b>เอกสารอ้างอิง</b></td>
                    <td>{{$date_customer['ref_doc']}}</td>
                </tr>
                <tr>
                    <td><b>ผู้ติดต่อ</b></td>
                    <td>{{$date_customer['contact_name']}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="line"></div>

<table class="wrap-box" cellpadding="0" cellspacing="0">
    <tr>
        <td><table class="wrap-content" cellpadding="3" cellspacing="0">
            <tr>
                <th style="width:5%;">#</th>                
                <th style="width:30%;">รายละเอียด</th>
                <th style="width:13%;">ประเภทภาษี 7%</th>
                <th style="width:20%;">โปรโมชั่น</th>
                <th style="width:10%;">จำนวน</th>
                <th style="width:10%;">ราคา/หน่วย</th>
                <th style="width:12%;">รวม</th>
            </tr>

            @php  
                $i = 1; 
                $sum_vat = 0;
                $disc = 0;
                $sum_price_vat = 0;
                $vat_i = 0;
            @endphp
            @foreach($cart_products['items'] as $item)
            @php
                $sum_vat += ($item['data']['price_vat'] - $item['data']['prodUnitPrice']) * $item['quantity'];
                $disc += ($item['data']['promotion'] != 'no') ? ($item['data']['price_vat'] * ($item['data']['discount'] / 100)) * $item['quantity'] : 0;
                $price_vat = ($item['data']['prodIsVat'] == 'I') ? ($item['data']['prodUnitPrice'] * 93 ) / 100 : $item['data']['prodUnitPrice'];
                $vat_i += ($item['data']['prodIsVat'] == 'I') ? ($item['data']['prodUnitPrice'] - (($item['data']['prodUnitPrice'] * 93 ) / 100)) * $item['quantity'] : 0;
                $sum_price_vat += $price_vat * $item['quantity'];
            @endphp
            <tr>
                <td style="text-align:center;">{{ $i }}</td>                    
                <td>{{ $item['data']['prodCode'] }} - {{ $item['data']['prodTName'] }}</td>
                <td style="text-align:right;">@if($item['data']['prodIsVat'] == 'I') รวมภาษี @elseif($item['data']['prodIsVat'] == 'Y') คิดภาษี @else ไม่คิดภาษี @endif</td>
                <td style="text-align:right;">@if($item['data']['promotion'] != 'no') {{ $item['data']['promotion'] }} (-{{ $item['data']['discount'] }}%) @else ไม่มี @endif</td>
                <td style="text-align:right;">{{ $item['quantity'] }} {{ $item['data']['uomName'] }}</td>
                <td style="text-align:right;">{{ number_format($price_vat, 2) }}</td>
                <td style="text-align:right;">{{ number_format($price_vat * $item['quantity'], 2) }}</td>
                @php  $i++; @endphp
            </tr>
            @endforeach 

        </table></td>
    </tr>
</table>

<table class="wrap-box" cellpadding="0" cellspacing="0">
    <tr>
        <td><table class="wrap-total" cellpadding="3" cellspacing="0">
                <tr>
                    <td style="width: 60%">&nbsp;</td>
                    <td style="width: 20%; font-weight: bold;">รวมทั้งหมด</td>
                    <td style="width: 20%;">{{ number_format($sum_price_vat, 2) }} บาท</td>
                </tr>                                    
                <tr>
                    <td>&nbsp;</td>
                    <td style="font-weight: bold;">ส่วนลด</td>
                    <td>{{ number_format($disc, 2) }} บาท</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td style="font-weight: bold;">ราคาหลังหักส่วนลด</td>
                    <td>{{ number_format($sum_price_vat - $disc, 2) }} บาท</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td style="font-weight: bold;">ภาษีมูลค่าเพิ่ม 7%</td>
                    <td>{{ number_format($sum_vat + $vat_i, 2) }} บาท</td>
                </tr>
                <!-- <tr>
                    <td>&nbsp;</td>
                    <td style="font-weight: bold;">ราคาไม่รวมภาษี</td>
                    <td>xx บาท</td>
                </tr> -->
                <tr>
                    <td style="text-align: center;">({{$baht}})</td>
                    <td style="font-weight: bold;"> รวมสุทธิทั้งหมด</td>
                    <td>{{ number_format($cart_products['totalPrice'], 2) }} บาท</td>
                </tr>
                <tr>
                    <td style="width: 50%">&nbsp;</td>
                    <td style="width: 10%"></td>
                    <td style="border-top: 0.5px solid #ccc; width: 40%;">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

    <!-- <table class="wrap-box" cellpadding="0" cellspacing="0">
        <tr>
            <td><b>หมายเหตุ</b><br />
            
            </td>
        </tr>
    </table>
     -->

<style>
    table.wrap-box {
        width: 100%;
        text-align: left;
        line-height: 97%;
    }

    table.wrap-top {
        width: 100%;        
        text-align: left;
        line-height: 97%;
    }

    table.wrap-content, table.wrap-total {
        width: 100%;        
        text-align: left;
        line-height: 97%;
    }
    table.wrap-content tr th{
        font-weight: bold;
        text-align: center;
        background-color: #eee;
    }

    table.wrap-content tr td{
        border-bottom-color: #ddd;
        border-bottom-style: solid;
        border-bottom-width: 0.5px;
    }

    table.wrap-total tr td{
        text-align: right;
    }

    .line-top{
        border-top: 1px solid #ccc;
    }
    .line-bottom{
        border-bottom: 1px solid #ccc;
    }
    .line-left{
        border-left: 1px solid #ccc;
    }
    .line-right{
        border-right: 1px solid #ccc;
    }

    .header-title {
        font-size: 22px;
        font-weight: bold;
    }    
</style>

