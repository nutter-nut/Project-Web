<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use File;
// use Response;

use App\Session;
use App\User;
use App\Message;
use App\User_nan;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $auto =  Message::collection('sessions')->getModifySequence('id') ;     
        // dd("test: ",$message ,"AUTO",$auto);
        return view('home');
    }

    public static function format($slq)
    {   
        $format = array();
        foreach ($slq as $key =>$value) {
            $id = $value['id'];
            $user_id = $value['0']['id'];
            $name = $value['0']['name'];
            $image = $value['0']['image'];
            $message = $value['message'];
            $status = $value['status'];
            $user_id = $value['user_id'];
            $created_at = $value['created_at'];
            
            array_push($format, array(
                "message_id" => $id,
                "message" => $message,
                "status" => $status,
                "user_id" => $user_id,
                "id" => $user_id,
                "name" => $name,
                "image" => $image,
                "created_at" => $created_at,
            ));
        }
        return $format;
    }

    private function deleteOldMessages($session)
    {
        $config = DB::connection('mongodb')->collection("config")->get();

        $date = $config[0]['value'] ? $config[0]['value']*1 : \Config::get('adminConfig.delete_old_messages');

        $last_month = date('Y-m-d h:i:s', time() - (86400 * $date));

        $delete_old_messages = DB::collection('messages')
            ->where([
                ['session','=',$session],
                ['status', '!=', 2],
                ['created_at', '<=', $last_month]
            ])
            ->delete();
            
        $delete_old_messages_image = DB::collection('messages')
            ->where([
                ['session','=',$session],
                ['status', '=', 2],
                ['created_at', '<=', $last_month]
            ])
            ->get();

        $delete_old_messages_file = DB::collection('messages')
            ->where([
                ['session','=',$session],
                ['status', '=', 2.1],
                ['created_at', '<=', $last_month]
            ])
            ->get();
            
        if($delete_old_messages_image != null){
            foreach($delete_old_messages_image as $item){
                $exists = Storage::disk('local')->exists('public/message_images/'.$item['message']);
                if($exists){
                    $del_image = Storage::disk('local')->delete('public/message_images/'.$item['message']);                    
                    DB::collection('messages')->where('id','=',$item['id']*1)->delete();
                }else{                    
                    DB::collection('messages')->where('id','=',$item['id']*1)->delete();    
                }
            }
        }

        if($delete_old_messages_file != null){
            foreach($delete_old_messages_file as $item){
                $exists = Storage::disk('local')->exists('public/message_images/file/'.$item['message']);
                if($exists){
                    $del_image = Storage::disk('local')->delete('public/message_images/file/'.$item['message']);
                    DB::collection('messages')->where('id','=',$item['id']*1)->delete();
                }else{
                    DB::collection('messages')->where('id','=',$item['id']*1)->delete();
                }
            }
        }
    }

    public function fetchMessages(Request $request)
    {
        $config = DB::connection('mongodb')->collection("config")->get();

        $limit = $config[1]['value'] ? $config[1]['value']*1 : \Config::get('adminConfig.limit_messages');

        $session = $request->session * 1;

        $type = ($request->type != null) ? $request->type * 1 : 1; //1=กล่องข้อความ 2=แอดมินดูข้อความ

        self::deleteOldMessages($session);

        $load = $request->load;
        (!$load) ? $load=1 : $request->load;
        $row = DB::collection('messages')->where([
            ['session','=',$session],
            ['status', '!=', 0],
            ['status', '!=', 3]
        ])->count();
        
        $skip = ($row * 1) - ($limit * $load);

        if($limit >= $row) $limit = $row;
        if($load >= 2){
            if($skip <= 0){
                if($skip > (0 - $limit)){
                    $x = $limit + $skip;
                    return self::fetchMessagesMore($session, 0, $x, $type, $load);
                }else return 0;
            }else return self::fetchMessagesMore($session, $skip, $limit, $type, $load);  
        }else return self::fetchMessagesMore($session, $skip, $limit, $type, $load);
    }

    public function addSession(Request $request)
    {
        $id_1 = $request->input('this_id');
        $id_2 = $request->input('f_id');

        $session = app('App\Http\Controllers\Chat\ChatController')->createSession($id_1, $id_2);
        
        return $session;
    }

    public function delSession(Request $request)
    {
        $session = $request->input('session');

        $del_session = DB::connection('mongodb')->collection("sessions")->where("id", "=", $session * 1)->delete();
        
        return $del_session * 1;
    }

    public static function fetchMessagesMore($session, $skip, $limit, $type, $load)
    {
        $result_session = DB::collection('messages')
                ->where([
                    ['session', '=', $session],
                    ['status', '!=', 0],
                    ['status', '!=', 3]
                ])
                ->skip($skip)
                ->take($limit) 
                ->get();

            $array_message = array();
            $users = array();

            foreach ($result_session as $key => $value) {
                $users = DB::collection('users')->where('id','=',$value['user_id']*1.0)->first();
                array_push($array_message, $value);
                array_push($array_message[$key], $users);
            }
    
            $session_event = DB::collection('sessions')->where('id','=',$session)->first();
            $result_message = self::format($array_message);
    
            if($type == 1){

                $user = Auth::user();
                $socket = array();
    
                array_push($socket, $result_message, $session_event, $user);
                return $socket;    

            }else{
                if($load == 1) return $result_message;
                else  return array_reverse($result_message);
            }
    }

    public static function messageReading($session,$status,$unread)
    {
        $str1 = explode(",", $unread)[0];
        $str2 = explode(",", $unread)[1];
        $id = Auth::user()->id;
        $id1 = DB::collection('sessions')->select('user_id1')->where('id','=',$session)->where('user_id1', $id)->first();
        if (!$id1) {
            $id2 = DB::collection('sessions')->select('user_id2')->where('id','=',$session)->where('user_id2', $id)->first();
            if($id2){
                $status == 1 ? $result2 = $str1 : $result2 = $str1 + 1;
                $unread_now2 = $result2 . ',' . $str2;
                $update_unread2 = DB::collection('sessions')->where('id','=',$session)->update(['unread' => $unread_now2]);
                return $result2;
            }
        }else{
            $status == 1 ? $result1 = $str2 : $result1 = $str2 + 1;
            $unread_now1 = $str1 . ',' . $result1;
            $update_unread1 = DB::collection('sessions')->where('id','=',$session)->update(['unread' => $unread_now1]);
            return $result1;
        }
    }

    public function sendMessage(Request $request)
    {
        $messages = $request->data['message']['message'];
        $session = $request->data['message']['session'];
        $id = $request->data['message']['id'];

        $message_insert = Message::collection("messages")->insert(
            [
                'id'=> Message::collection("messages")->getModifySequence('id') ,
                "user_id" => $id,
                "session" => $session,
                "message" => $messages,
                "status" => 1,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ]);

        $user = Auth::user();
        $message = $request->data['message'];

        $reading = DB::collection('sessions')->select('reading')->where('id','=',$session)->first();
        $get_reading = $reading['reading'];
        $str = DB::collection('sessions')->select('unread')->where('id','=',$session)->first();
        $get_str = $str['unread'];
        $count_unread = self::messageReading($session,$get_reading,$get_str);

        $last_id = DB::collection('messages')->where('session','=',$session)->orderBy('id', 'desc')->first();

        $socket = array();
        array_push($socket,$user,$message,$session,$count_unread,$last_id['id']);

        return $socket;

    }

    public function updateMessage(Request $request)
    {
        $id = $request->data['id'];
        $message = $request->data['message'];
        $date = date("Y-m-d H:i:s");
        $message_update = DB::collection('messages')->where('id',$id)->update(['message' => $message, 'updated_at' => $date]);
        // return ['status' => 'Message Update!'];
        return $message_update;
    }

    public function destroyMessage(Request $request)
    {
        $id = $request->id;
        $message_delete = DB::collection('messages')->where('id',$id*1.0)->update(['status' => 0]);
        // return ['status' => 'Message Delete!'];
    }

    public function reCount(Request $request)
    {
        $session = $request->session;
        $id = Auth::user()->id;
        
        $str = DB::collection('sessions')->select('unread')->where('id','=',$session)->first();
        $get_str = $str['unread'];
        $str1 = explode(",", $get_str)[0];
        $str2 = explode(",", $get_str)[1];

        $id1 = DB::collection('sessions')->select('user_id1')->where('id','=',$session)->where('user_id1', $id)->first();
        if(!$id1){
            $id2 = DB::collection('sessions')->select('user_id2')->where('id','=',$session)->where('user_id2', $id)->first();
            if($id2){
                $re_unread2 = $str1 . ",0";
                $update_re_unread2 = DB::collection('sessions')->where('id','=',$session)->update(['unread' => $re_unread2]);
                return $update_re_unread2;
            }
        }else{
            if ($id == $id1['user_id1']) {
                $re_unread1 = "0," . $str2;
                $update_re_unread1 = DB::collection('sessions')->where('id','=',$session)->update(['unread' => $re_unread1]);
                return $update_re_unread1;
            }
        }
    }

    public function reading(Request $request)
    {
        $session_reading = $request->data['session_reading'];
        $diff = array();
        array_push($diff, $session_reading);

        $id_1 = $request->data['session']['user_id1'];
        $id_2 = $request->data['session']['user_id2'];

        $session_id1_1 = Db::collection('sessions')->select('id')->where('user_id1',$id_1)->get();
        $session_id1_2 = Db::collection('sessions')->select('id')->where('user_id2',$id_1)->get();
        $session_id2_1 = Db::collection('sessions')->select('id')->where('user_id1',$id_2)->get();
        $session_id2_2 = Db::collection('sessions')->select('id')->where('user_id2',$id_2)->get();

        $session = array();
        array_push($session, $session_id1_1, $session_id1_2, $session_id2_1, $session_id2_2);

        $result = array();
        $keys = array_keys($session);
        for ($i = 0; $i < count($session); $i++) {
            foreach ($session[$keys[$i]] as $key => $value) {
                array_push($result, $value['id']);
            }
        }
        $unique = array_unique($result);
        $diff_session_reading = array_diff($unique, $diff);

        $session_reading = DB::collection('sessions')->where('id','=',$session_reading)->update(['reading' => 1]);

        foreach ($diff_session_reading as $key => $value) {
            $session_re_reading = DB::collection('sessions')->where('id','=',$value)->update(['reading' => 0]);
        }
        // return $session_reading;
    }

    public function reReading(Request $request)
    {
        $id = $request->data['user_id'];
        $session_reading = $request->data['session'];
        $diff = array();
        array_push($diff, $session_reading);

        $id1 = DB::collection('sessions')->where('user_id1','=',$id)->get();
        $id2 = DB::collection('sessions')->where('user_id2','=',$id)->get();

        $session = array();
        array_push($session, $id1, $id2);
        $result = array();
        $keys = array_keys($session);

        for ($i = 0; $i < count($session); $i++) {
            foreach ($session[$keys[$i]] as $key => $value) {
                array_push($result, $value['id']);
            }
        }

        $diff_session_reading = array_diff($result, $diff);

        foreach ($diff_session_reading as $key => $value) {
            DB::collection('sessions')->where('id','=',$value)->update(['reading' => 0]);
        }
    }

    public function uploadFile(Request $request)
    {
        $session = $request->get('session')*1;

        if($request->get('image') && $request->hasFile('file')){

          $image = $request->get('image');

          $file = $request->file('file');

          $file_name = $file->getClientOriginalName();
          
          $extension = $file->extension();

          if($extension == 'jpeg' || $extension == 'png' || $extension == 'jpg'){

            $name = $session.'_'.time().'.' . $extension;

            $resize = \Image::make($image)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg');

            $hash = md5($resize->__toString());

            Storage::put('public/message_images/'.$name, $resize->__toString());

            $status = 2;

            $file_type = 'image';

            //   \Image::make($request->get('image'))->save(public_path('images/message_images/').$name);

          }elseif($extension == 'pdf' || $extension == 'docx' || $extension == 'xlsx'){

            $name = $session.'_'.time().'_'.$file_name;
      
            $imageEncoded = File::get($file);

            Storage::put('public/message_images/file/'.$name, $imageEncoded);

            $status = 2.1;

            $file_type = 'file';

          }else{

            $name = '';

            $status = 0;

            return false;

          }

          $id = Auth::user()->id;
          
          $message_insert = Message::collection("messages")->insert(
            [
                'id'=> Message::collection("messages")->getModifySequence('id') ,
                "user_id" => $id,
                "session" => $session,
                "message" => $name,
                "status" => $status,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            $message = $name;
            
            $user = Auth::user();  
         
            $reading = DB::collection('sessions')->select('reading')->where('id','=',$session)->first();
            $get_reading = $reading['reading'];
            $str = DB::collection('sessions')->select('unread')->where('id','=',$session)->first();
            $get_str = $str['unread'];
            $count_unread = self::messageReading($session,$get_reading,$get_str);
    
            $last_id = DB::collection('messages')->where('session','=',$session)->orderBy('id', 'desc')->first();
    
            $socket = array();
            array_push($socket,$user,$message,$session,$count_unread,$last_id['id'],$file_type);
            return $socket;
        }
        
     }

     public function downloadFile($fileName)
     {

        $extension = explode(".",$fileName);

        if($extension[1] == 'xlsx' || $extension[1] == 'docx'){

            $extension = 'octet-stream';

        }elseif($extension[1] == 'pdf'){

            $extension = 'pdf';

        }else{
            return false;
        }
        
        $file = Storage::disk('local')->get('public/message_images/file/'.$fileName);
 
		return (new Response($file, 200))->header('Content-Type', 'application/'.$extension);

     }

     public function videoTime(Request $request)
     {
        $time_insert = Message::collection("messages")->insert(
            [
                'id'=> Message::collection("messages")->getModifySequence('id') ,
                "user_id" => $request->data['user_id']*1,
                "session" => $request->data['session']*1,
                "message" => $request->data['time'],
                "status" => 3,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ]);
     }

     public function videoTimeEnd(Request $request)
     {
        $session = DB::collection('sessions')
            ->where('id', '=', $request->data['session']*1)
            ->first();
        $user = array();
        array_push($user, $session['user_id1'], $session['user_id2']);
        self::deleteElement($request->data['user_id'] ,$user);
        if(count($user) > 1){
            $user_from_email = User::select()->where('email', '=', $request->data['user_id'])->first();
            $time_start = DB::collection('messages')->where('session','=',$request->data['session']*1)->where('status','=',3)->orderBy('id', 'desc')->first();
            if($time_start){
                $time_end = $request->data['time']*1.0;
                $time = ($time_end - ($time_start['message']*1));
                $time_format = self::time_elapsed_A($time/1000);
                $date = date("Y-m-d H:i:s");
                $time_start_update = DB::collection('messages')->where('id',$time_start['id'])->update([
                    'message' => $time_format,
                    'status' => 4,
                    'updated_at' => $date
                    ]);
                $socket = array();
                $message = array($time_format,'time');
                array_push($socket,$user_from_email,$message,$request->data['session']);
                return $socket;
            }
        }else{
            $user_from_id = User::select()->where('id', '=', $user[0])->first();
            $time_start = DB::collection('messages')->where('session','=',$request->data['session']*1)->where('status','=',3)->orderBy('id', 'desc')->first();
            if($time_start){
                $time_end = $request->data['time']*1.0;
                $time = ($time_end - ($time_start['message']*1));
                $time_format = self::time_elapsed_A($time/1000);
                $date = date("Y-m-d H:i:s");
                $time_start_update = DB::collection('messages')->where('id',$time_start['id'])->update([
                    'message' => $time_format,
                    'status' => 4,
                    'updated_at' => $date
                    ]);
                $socket = array();
                $message = array($time_format,'time');
                array_push($socket,$user_from_id,$message,$request->data['session']);
                return $socket;
            }
        }
     }

     public function getBadge()
     {
        $id = Auth::user()->id*1;

        $id1 = DB::collection('sessions')->select()->where('user_id1','=',$id)->get();
        $id2 = DB::collection('sessions')->select()->where('user_id2','=',$id)->get();

        $count_id1 = 0;
        foreach($id1 as $item){
            $get_str = $item['unread'];
            $str1 = explode(",", $get_str)[0];
            $count_id1 += $str1;
        }

        $count_id2 = 0;
        foreach($id2 as $item){
            $get_str = $item['unread'];
            $str2 = explode(",", $get_str)[1];
            $count_id2 += $str2;
        }

        return $count_id1 + $count_id2;
     }
    
     public function time_elapsed_A($secs)
     {
        $bit = array(
            'y' => $secs / 31556926 % 12,
            'w' => $secs / 604800 % 52,
            'd' => $secs / 86400 % 7,
            'h' => $secs / 3600 % 24,
            'm' => $secs / 60 % 60,
            's' => $secs % 60
            );
           
        foreach($bit as $k => $v)
            if($v > 0)$ret[] = $v . $k;
           
        return join(' ', $ret);
    }

    public function deleteElement($element, $array)
    {
        $index = array_search($element, $array);
        if($index !== false){
            unset($array[$index]);
        }
    }

    public function createSession($id_1, $type)
    {
        if($type == 'random'){
            $user_sale = User_nan::database()->collection("users")->select('id', 'name')->where("sale", "=", 1)->andwhere("status", "=", "online")->groupby('id', 'name')->random(1);

            if ($user_sale == null) {
                $user_sale = User_nan::database()->collection("users")->select('id', 'name')->where("sale", "=", 1)->groupby('id', 'name')->random(1);
            }

            $id_2 = $user_sale[0]['id'] * 1;
        }else{
            $id_2 = $type;
        }

        $session = Session::database()->collection("sessions")->insertGetId([
            'id' => Session::database()->collection("sessions")->getModifySequence('id'),
            'user_id1' => $id_1 * 1,
            'user_id2' => $id_2 * 1,
            'unread' => ($type == 'random') ? "1,0" : "0,0",
            'reading' => 0
        ], 'id');

        if($type == 'random') $this->firshMessage($session, $id_2);

        return $session;
    }

    public function firshMessage($session, $sale_id)
    {
        $config = DB::connection('mongodb')->collection("config")->where('config','=','first_messages')->first();

        if ($session) {
            $message_insert = Message::collection("messages")->insert(
                [
                    'id' => Message::collection("messages")->getModifySequence('id'),
                    "user_id" => $sale_id * 1,
                    "session" => $session[2] * 1,
                    "message" => $config['value'] ? $config['value'] : \Config::get('adminConfig.first_messages'),
                    "status" => 1,
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s")
                ]
            );
        }
    }

}
