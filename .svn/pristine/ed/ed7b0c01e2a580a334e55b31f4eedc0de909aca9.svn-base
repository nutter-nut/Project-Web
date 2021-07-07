<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body> 
    Example order ID  for check : EX20210508090832 <br>  
    @if (!isset($orderdetail['status']))
    <table>
    @foreach( $orderdetail as $key => $data)
      <tr>
           <td> {{ $key }}: </td><td> {{ $data }} </td> 
       </tr>
    @endforeach
    </table>
   
    @endif
   <br>
   

    <form action="/checkorder" method="get">
        <label for="orderid">Order ID</label>
        <input type="text" name="orderid" id="orderid">
        <input type="submit" value="Check Order">
    </form>
</body>
</html>