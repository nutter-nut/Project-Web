@if(Auth::check())
<!-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"> -->

<div id="app">
    @php
    $user = array(
        'id' => Auth::user()->id,
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'image' => Auth::user()->image,
        'status' => Auth::user()->status,
        );
    @endphp

    <chat-component 
        v-bind:user="{{  json_encode($user) }}"
        :messages="messages" 
        :badge="badge" 
        v-on:messagesent="addMessage"
        v-on:session="addSession"
        v-on:delete_message="delMessage"
        v-on:load_readed="loadReaded"
    ></chat-component>
</div>

<script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/box.js') }} "></script>
<script src="{{ asset('js/app.js') }}"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!-- <script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script> -->

@endif