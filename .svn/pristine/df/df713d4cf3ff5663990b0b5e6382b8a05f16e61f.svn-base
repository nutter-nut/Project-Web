<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABPON QRCODE</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
    body {
        background: #eff0eb;
        background-image: url('https://i.postimg.cc/MTbfnkj6/bg.png');
        background-size: cover;
        background-repeat: no-repeat;
    }
    .blockquote-custom {
        position: relative;
        font-size: 1.1rem;
    }
    .blockquote-custom-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: -25px;
        left: 50px;
    }
    </style>
</head>
<body>

<section class="py-5">
    <div class="container">
        <!-- FOR DEMO PURPOSE -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <header class="text-center pb-5">
                    <h1 class="h2">QR Code Promptpay</h1>
                    <b>Transection ID: </b>{{ $transaction_ID }}
                </header>
            </div>
        </div><!-- END -->


        <div class="row">
            <div class="col-lg-6 mx-auto">

                <!-- CUSTOM BLOCKQUOTE -->
                <blockquote class="blockquote blockquote-custom bg-white p-5 shadow rounded">
                    <div class="blockquote-custom-icon bg-info shadow-sm"><i class="fa fa-quote-left text-white"></i></div>
                    <center><img id="qrpayment" src="{{ $image_qrprom }}" alt="" ></center>

                    <div class="table-responsive pt-5">
                        <table class="table table-hover">
                            <tbody>
                                @foreach($ms_data as $key => $item)
                                <tr>
                                    <th scope="row" class="text-center">{{ $key }}</th>
                                    <td class="text-center">{{ $item }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <footer class="blockquote-footer pt-4 mt-4 border-top">
                        <cite title="Source Title">
                            <a href="{{ route('Index') }}">ยกเลิก</a>
                        </cite>
                        <a class="btn btn-outline-success btn-sm" href="{{ route('Index') }}" role="button" style="float:right;" onclick="{{ \Session::forget('cart') }}">ชำระเงินเรียบร้อยแล้ว</a>
                    </footer>
                </blockquote><!-- END -->

            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setInterval(function () {
            $.ajax({
                url: "./Check_Transaction.php",
                data: {'transaction_ID': ' {{ $transaction_ID }} '}, // รหัสธุรกรรม
                type: 'POST',
                success: function (data, textStatus, jqXHR) {

                    let res = JSON.parse(data);

                    if (res[0]['Status Payment '] == "Pay Success"){ // ตรวจสอบสถานะ

                        $("#scan").hide(); // ซ่อนข้อความ
                        $("#qrpayment").hide(); // ซ่อน QR
                        $("#successpayment").show(); // โชว์ข้อความ
                    }

                }
            });
        }, 1000);
    });

</script>

</body>
</html>