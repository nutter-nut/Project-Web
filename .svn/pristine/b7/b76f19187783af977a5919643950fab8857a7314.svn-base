<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\User_nan;
use App\User;
use App\Address;

class ProfileController extends Controller
{
    public function showdata(){
        $id = Auth::user()->id;

        $user = DB::connection('mongodb')->collection("users")->where('id','=', $id*1)->first();

        $address = self::getAddress($id);

        return view('login.profile',[
                'user' => $user,
                'address' => $address
            ]);
    }
    public function resetpass(Request $request){
        $id = Auth::user()->id;
        $user = DB::connection('mongodb')->collection("users")->where('id','=', $id*1)->first();
        $password = $user['password'];

        $user_id = User_nan::collection('users')->select('id')->get();
    
        $array_id = [];
        foreach ($user_id as $item) {
            array_push($array_id, $item['id']);
        }
        
        //$passswordd = $password 
        //dd($password);
        //dd($password);
        return view('login.resetpassword',[
                'user' => $user,
                'user_id' => $array_id,
            ]);
    }
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'newpassword' => 'min:6|required_with:connewpassword|same:connewpassword',
            'connewpassword' => 'min:6'
        ]);

        $user = DB::connection('mongodb')->collection("users")->where('id','=', $id*1)->first();
        $passwordc = $user['password'];
    
        $password = $request->input('password');
        $passwordhash = Hash::make($password);
        //dd($passwordhash);
        // $test = sha1("1234");
        // dd($test);
        $newpassword = $request->input('newpassword');
        $connewpassword = $request->input('connewpassword');
        $hasher = app('hash');
        ///dd($hasher);
        
        //resetpasssword if erorr
        // if($passwordc == $passwordhash){
        //     $save = DB::connection('mongodb')->collection("users")
        //     ->where('id',"=",$id*1)
        //     ->update([
        //         'password' => Hash::make($newpassword),
        //         ]);
        // }elseif($newpassword != $connewpassword){
        //     return back()->with('fail','รหัสผ่านใหม่ไม่ตรงกัน');
        // }else{
        //     $error = "error";
        //     //dd($error);
        //     return back()->with('fail','รหัสผ่านเก่าไม่ตรงกัน');
        // }

        //resetpassword not if check
        if($newpassword != $connewpassword){
            $error = "error";
            return back()->with('fail', (\Session::get('locale') != "th") ? 'Passwords do not match' : 'รหัสผ่านไม่ตรงกัน');
        }else{
            $save = DB::connection('mongodb')->collection("users")
            ->where('id',"=",$id*1)
            ->update([
                'password' => Hash::make($newpassword),
                ]);
        }
        
        if($save){
            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'update password', [
                'th' => 'อัพเดทรหัสผ่าน',
                'en' => 'Update password.',
            ]);

             return redirect()->route('profile')->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
        }else{
            return redirect()->route('profile')->with('fail', (\Session::get('locale') != "th") ? 'Save is not successful.' : 'บันทึก ไม่สำเร็จ');
        }
    }
    public function editProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:32',
            'f_name' => 'required',
            'l_name' => 'required',
            'tel' => 'required',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');

        $prefix = $request->input('prefix');
        $first_name = $request->input('f_name');
        $last_name = $request->input('l_name');
        $tel = $request->input('tel');
        //dd($name);

        if($request->hasFile("image")){

            $user = DB::connection('mongodb')->collection("users")->where('id', "=", Auth::user()->id*1)->first();

            $ext = $request->file('image')->getClientOriginalExtension();
            
            $file_name = explode('.', $request->file('image')->getClientOriginalName())[0];
     
            // $stringIameReFormat = str_replace(" ", "", $user['id']);
            
            $imageName = Auth::user()->id."_".$file_name.".".$ext;

            $imageEncoded = File::get($request->image);

            $exists = Storage::disk('local')->exists("public/user_images/".$user['image']);

            if($exists && $user['image'] != 'default.jpg'){
                Storage::delete('public/user_images/'.$user['image']);
            }

            $save_image = Storage::disk('local')->put('public/user_images/'.$imageName, $imageEncoded);
            
            $edit = DB::connection('mongodb')->collection("users")->where('id', Auth::user()->id*1)->update(['prefix' => $prefix, 'first_name' => $first_name, 'last_name' => $last_name, 'tel' => $tel, 'image' => $imageName]);

            if($save_image){
                app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'update image profile', [
                    'th' => 'อัพเดทรูปภาพโปรไฟล์',
                    'en' => 'Update image profile.',
                ]);

                return redirect()->route('profile')->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
            }else{
                return redirect()->route('profile')->with('fail', (\Session::get('locale') != "th") ? 'Save is not successful.' : 'บันทึก ไม่สำเร็จ');
            }

        }else{

            $edit = DB::connection('mongodb')->collection("users")->where('id', Auth::user()->id*1)->update(['prefix' => $prefix, 'first_name' => $first_name, 'last_name' => $last_name, 'tel' => $tel]);

            if($edit){
                return redirect()->route('profile')->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
            }else{
                return redirect()->route('profile')->with('fail', (\Session::get('locale') != "th") ? 'Save is not successful.' : 'บันทึก ไม่สำเร็จ');
            }
        }

    }

    public function getAddress($user_id)
    {
        $address = DB::connection('mongodb')->collection("address")->where('user_id','=', $user_id * 1)->get();

        return $address;
    }

    public function addressInset(Request $request)
    {
        $request->validate([
            'place_name' => 'required|max:32',
            'first_name' => 'required|max:32',
            'last_name' => 'required|max:32',
            'phone' => 'required|max:12',
            'address' => 'required|max:256',
        ]);

        $new_address_array = array(
            'id' => Address::database()->collection("address")->getModifySequence('id'),
            'user_id' => Auth::user()->id,
            'place_name' => $request->input('place_name'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $save = Address::database()->collection("address")->insert($new_address_array);

        if($save){
            return redirect()->route('profile')->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
        }else{
            return redirect()->route('profile')->with('fail', (\Session::get('locale') != "th") ? 'Save is not successful.' : 'บันทึก ไม่สำเร็จ');
        }
    }

    public function addressEdit($id)
    {
        $address = DB::connection('mongodb')->collection("address")->where('id','=', $id*1)->first();

        return $address;
    }

    public function addressUpdate(Request $request, $user_id)
    {
        $id = $request->input('id_edit');

        $place_name = $request->input('place_name_edit');
        $first_name = $request->input('first_name_edit');
        $last_name = $request->input('last_name_edit');
        $phone = $request->input('phone_edit');
        $address = $request->input('address_edit');

        $get_address = DB::connection('mongodb')->collection("address")->where('id','=', $id*1)->first();
        if($user_id != $get_address['user_id']) return back()->with('fail', (\Session::get('locale') != "th") ? 'The authorization was not successful.' : 'การอนุญาต ไม่สำเร็จ');

        $save = DB::connection('mongodb')->collection("address")
        ->where('id', "=", $id * 1)
        ->update([
            'place_name' => $place_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'address' => $address,
            'updated_at' => date('Y-m-d H:i:s')
            ]);

        if($save){
            return redirect()->route('profile')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
        }else{
            return redirect()->route('profile')->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
        }
    }

    public function addressDelete($id)
    {
        $delete = DB::connection('mongodb')->collection("address")->where("id", "=", $id*1)->delete();

        if($delete){
            return redirect()->route('profile')->withsuccess((\Session::get('locale') != "th") ? 'Deleted successfully.' : 'ลบสำเร็จ');
        }else{
            return redirect()->route('profile')->with('fail', (\Session::get('locale') != "th") ? 'Failed to delete.' : 'ลบ ไม่สำเร็จ');
        }
    }
}
