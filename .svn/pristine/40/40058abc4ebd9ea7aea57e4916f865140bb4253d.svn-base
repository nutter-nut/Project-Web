@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
    <button type="button" class="close " data-dismiss="alert"><span style="font-size:30px;" class="" aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> {{session('success')}}
</div>
@elseif(\Session::has('fail'))
<div class="alert alert-danger alert-dismissible">
    <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
    <button type="button" class="close " data-dismiss="alert"><span style="font-size:30px;" class="" aria-hidden="true">&times;</span></button>
    <strong>Error!</strong> {{\Session::get('fail')}}
</div>
@elseif($errors->any())
<div class="alert alert-danger">
    <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
    <button type="button" class="close " data-dismiss="alert"><span style="font-size:30px;" class="" aria-hidden="true">&times;</span></button>
    <strong>Error!</strong>
    <ul>
    @foreach($errors->all() as $item)
        <li>{{ $item }}</li>
    @endforeach
    </ul>
</div>
@endif

{{--
@if(strpos($errors->all()[0],"The rating field is required" ) >= 0 )
<strong>Error!</strong>
<strong>กรุณาให้คะแนนจำนวนดาวด้วยครับ</strong>
@else
<strong>Error!</strong> {{print_r($errors->all())}}
@endif
--}}