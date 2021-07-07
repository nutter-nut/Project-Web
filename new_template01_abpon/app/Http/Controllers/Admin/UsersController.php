<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Auth;
use Carbon\Carbon;

use App\User;
use App\User_nan;

class UsersController extends Controller
{
    public function checkImageFile($image)
    {
        $exists = \File::exists('storage/user_images/' . $image);

        $data = [
            'exists' => $exists,
            'file_name' => $image,
            'url' => $exists ? url("storage/user_images/{$image}") : url("storage/user_images/default.jpg"),
        ];

        return $data;
    }

    public function index($text = null)
    {
        $users = User_nan::collection('users')->select('*')->where('id','!=',0)->orderby('id','desc')->get();

        $user_image = [];
        foreach($users as $key => $item){
            $user_image[$key] = self::checkImageFile($item['image']);
        }

        return view('login.admin.displayUsers', [
            'users' => $users,
            'user_image' => $user_image
        ]);
    }

    public function getUserData($id)
    {
        $user = User_nan::collection("users")->select('id', 'admin', 'employee', 'sale', 'name', 'prefix', 'first_name', 'last_name', 'tel', 'email','image','language','banned_until')->where('id', "=", $id*1)->first();

        return $user[0];
    }

    public function getUserAll($id)
    {
        $have_user = app('App\Http\Controllers\Chat\UserController')->getFriends2($id);
        
        $users = User_nan::collection("users")->select(
                'id', 
                'admin', 
                'employee', 
                'sale', 
                'name', 
                'prefix', 
                'first_name', 
                'last_name', 
                'tel', 
                'email', 
                'image', 
                'language', 
                'banned_until'
            )
            ->where('banned_until', "=", "1")
            ->andWhere('id', "!=", $id * 1)
            ->get();
        
        $result = array();
        foreach ($users as $key => $value){
            foreach ($have_user as $key2 => $value2){
                if($value['email'] == $value2['email'])
                    unset($users[$key]);
            }
        }
        $new_users = array_values($users);

        rsort($new_users);
        return $new_users;
    }

    public function userInsert(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => 'required|unique:users|email|max:255',
            'prefix' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'password' => 'min:8|required_with:password_confirm|same:password_confirm',
            'password_confirm' => 'min:8'
        ]);

        $id = User_nan::database()->collection("users")->getModifySequence('id');

        $data_image = [
            'hasFile' => $request->hasFile("image"),
            'file' => $request->file('image'),
            'id' => $id,
            'data_file' => $request->image,
            'type' => 1
        ];
        $image = self::uplodeImage($data_image);

        $user_data_insert = array(
            'id' => $id,
            'admin' => ($request->input('is_admin') != null) ? $request->input('is_admin') * 1 : 0,
            'employee' => '0',
            'sale' => ($request->input('is_sale') != null) ? $request->input('is_sale') * 1 : 0,
            'language' => "th",
            'name' => $request->input('username'),
            'prefix' => $request->input('prefix'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'status' => "offline",
            'image' => $image,
            'email' => $request->input('email'),
            'tel' => $request->input('phone_number'),
            'password' => Hash::make($request->input('password')),
            'banned_until' => "1",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $save = self::userArrayInsert($user_data_insert);

        if($save){
            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'user', [
                'th' => 'สร้างบัญชีผู้ใช้ ' . $request->input('username'),
                'en' => 'Create a ' . $request->input('username') . ' user account.',
            ]);

            return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
        }else{
            return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Save is not successful.' : 'บันทึก ไม่สำเร็จ');
        }
    }

    public function userInsertPosone(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $validatedData = $request->validate([
            'username' => 'required|unique:userlogin|max:255',
            'email' => ['required', 'string', 'max:255'],
            'prefix' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['required'],
            'password' => 'min:8|required_with:password_confirm|same:password_confirm',
            'password_confirm' => 'min:8'
        ]);

        $email = $request->input('email');
        $check_email = self::checkEmail($email);
        if($check_email != null) return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'This email has already been used.' : 'อีเมลนี้ถูกใช้แล้ว');

        $id = User_nan::database()->collection("users")->getModifySequence('id');
        $emp_code = self::lastEmpCode();

        $posone_user_data_insert = [
            'emp_code' => $emp_code,
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'prefix' => self::getPrefix($request->input('prefix'))[1],
            'nick_name' => $request->input('nick_name'),
            'citizenid' => $request->input('citizenid'),
            'phone_number' => $request->input('phone_number'),
            'status' => $request->input('status'),
            'address' => $request->input('address'),
            'created_date' => date('Y-m-d'),
            'empPOSName' => self::getPrefix($request->input('prefix'))[0] . '-' . $request->input('first_name') . '-' . $request->input('last_name'),
            'empPOSPeopleId' => str_replace("-", "", $request->input('citizenid')),
            'empPOSTel' => str_replace("-", "", $request->input('phone_number')),
            'empPOSTaxId' => str_replace("-", "", $request->input('empPOSTaxId')),
            'empPOSReferName' => self::getPrefix($request->input('refer_prefix'))[0] . '-' . $request->input('refer_first_name'),
            'empPOSReferSurName' => $request->input('refer_last_name'),
            'empPOSReferAddress' => $request->input('refer_address'),
        ];
        self::userSaveToPosone($posone_user_data_insert);

        $data_image = [
            'hasFile' => $request->hasFile("image"),
            'file' => $request->file('image'),
            'id' => $id,
            'data_file' => $request->image,
            'type' => 1
        ];
        $image = self::uplodeImage($data_image);

        $user_data_insert = array(
            'id' => $id,
            'admin' => ($request->input('is_admin') != null) ? 1 : 0,
            'employee' => $emp_code,
            'sale' => ($request->input('is_sale') != null) ? 1 : 0,
            'language' => "th",
            'name' => $request->input('username'),
            'prefix' => $request->input('prefix'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'tel' => $request->input('phone_number'),
            'status' => "offline",
            'image' => $image,
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'banned_until' => "1",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $save = self::userArrayInsert($user_data_insert);

        if($save){
            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'user', [
                'th' => 'สร้างบัญชีผู้ใช้ ' . $request->input('username'),
                'en' => 'Create a ' . $request->input('username') . ' user account.',
            ]);

            return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
        }else{
            return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Save is not successful.' : 'บันทึก ไม่สำเร็จ');
        }
    }

    public function userArrayInsert($user_data_insert)
    {
        $save = User_nan::database()->collection("users")->insert($user_data_insert);

        return $save;
    }

    public function userArrayUpdate($id, $user_data_update)
    {
        $save = DB::connection('mongodb')->collection("users")->where('id', "=", $id * 1)->update($user_data_update);

        return $save;
    }

    public function checkEmail($email)
    {
        $email = DB::connection('mongodb')->collection("users")->where('email', '=', $email)->first();

        return $email;
    }

    public function lastEmpCode()
    {
        $last_user_qury = "select * from userlogin order by userLoginId desc limit 1";
        $last_user = DB::select(DB::raw($last_user_qury));

        if($last_user != null){

            $arr_emp_code = explode("-", $last_user[0]->empCode);
    
            $emp_code = substr(str_repeat(0, 4).($arr_emp_code[2]+1), - 4);

            $full_emp_code = "EMP-00-" . $emp_code;
        }else{
            $full_emp_code = "EMP-00-0001";
        }

        return $full_emp_code;
    }

    public function getPrefix($prefix)
    {
        switch ($prefix) {
            case "mr":
                return ['นาย', 'M'];
                break;
            case "ms":
                return ['นางสาว', 'F'];
                break;
            case "mrs":
                return ['นาง', 'F'];
                break;
            default:
                return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Prefix unknown.' : 'คำนำหน้าที่ไม่รู้จัก');
          }
    }

    public function uplodeImage($data)
    {
        if($data['type'] == 1){ //insert

            if($data['hasFile']){
    
                $ext = $data['file']->getClientOriginalExtension();
                
                $file_name = explode('.', $data['file']->getClientOriginalName())[0];
    
                $imageName = $data['id']."_".$file_name.".".$ext;
    
                $imageEncoded = File::get($data['data_file']);
    
                $save_image = Storage::disk('local')->put('public/user_images/'.$imageName, $imageEncoded);
    
                $image = $imageName;
            }else{
                $image = "default.jpg";
            }

            return $image;

        }elseif($data['type'] == 2){ //update

            $image_old = DB::connection('mongodb')->collection("users")->select('image')->where('id', "=", $data['id'] * 1)->get();

            if($data['hasFile']){

                $exists = Storage::disk('local')->exists('public/user_images/'.$image_old[0]['image']);
    
                if($exists && $image_old[0]['image'] != 'default.jpg') Storage::disk('local')->delete('public/user_images/'.$image_old[0]['image']);

                $ext = $data['file']->getClientOriginalExtension();
                
                $file_name = explode('.', $data['file']->getClientOriginalName())[0];
    
                $imageName = $data['id']."_".$file_name.".".$ext;
    
                $imageEncoded = File::get($data['data_file']);
    
                $save_image = Storage::disk('local')->put('public/user_images/'.$imageName, $imageEncoded);
    
                $image = $imageName;

            }else{
                $image = $image_old[0]['image'];
            }

            return $image;
        } 
    }

    public function getUserInPosone($empCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select 
                        ul.username, 
                        ul.status, 
                        ey.empCode,
                        ey.empId,
                        ey.empCode,
                        ey.empPOSName,
                        ey.empPOSNickName,
                        ey.empPOSPicture,
                        ey.empPOSStartDate,
                        ey.empPOSEndDate,
                        ey.empPOSType,
                        ey.empPOSPeopleId,
                        ey.empPOSTaxId,
                        ey.empPOSSocialCardNo,
                        ey.empPOSDriverCardNo,
                        ey.empPOSGender,
                        ey.empPOSMaritalStatus,
                        ey.empPOSAddress,
                        ey.empPOSTel,
                        ey.empPOSEmail,
                        ey.empPOSReferName,
                        ey.empPOSReferSurName,
                        ey.empPOSReferAddress,
                        ey.empPOSPositionCode,
                        ey.empPOSDivisionCode,
                        ey.insCost,
                        ey.insUniformCost,
                        ey.CompanyCode,
                        ey.statusSending
                    from employeepos ey
                    inner join userlogin ul
                    on ey.empCode = ul.empCode 
                    where ey.empCode='".$empCode."' 
                    or ul.username='".$empCode."'
                ";

        $get_user = DB::select(DB::raw($qury));

        return $get_user;
    }

    public function userUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'username' => 'required|max:32',
            'prefix_edit' => 'required',
            'first_name_edit' => 'required',
            'last_name_edit' => 'required',
            'phone_number_edit' => 'required',
            'password_status' => 'required',
        ]);

        $user_id = $request->input('user_id');

        $data_image = [
            'hasFile' => $request->hasFile("image"),
            'file' => $request->file('image'),
            'id' => $user_id,
            'data_file' => $request->image,
            'type' => 2
        ];
        $image = self::uplodeImage($data_image);

        $user_data_update = array(
            'admin' => ($request->input('is_admin_edit') != null) ? 1 : 0,
            'sale' => ($request->input('is_sale_edit') != null) ? 1 : 0,
            'employee' => '0',
            'prefix' => $request->input('prefix_edit'),
            'first_name' => $request->input('first_name_edit'),
            'last_name' => $request->input('last_name_edit'),
            'tel' => $request->input('phone_number_edit'),
            'image' => $image,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $user_check_posone = self::existsUserCheckAtPosone($request->input('username'));
        if($user_check_posone){ //1 มีอยู่ / 0 ยังไม่มี //update at posone
            $get_user = self::getUserAtPosone($request->input('username'));
            self::LayOff($get_user->empCode); //เลิกจ้าง

            $image = self::uplodeImage($data_image);
    
            $save = self::userArrayUpdate($user_id, $user_data_update);

            if($save){
                return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'Successful dismissal.' : 'อัพเดทเลิกจ้าง สำเร็จ');
            }else{
                return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
            }
        }

        $reset_password_check = ($request->input('password_status') != '0');
        if($reset_password_check){
            $validatedData = $request->validate([
                'password' => 'min:8|required_with:password_confirm|same:password_confirm',
                'password_confirm' => 'min:8'
            ]);
            $new_password = $request->input('password');

            $user_data_update['password'] = Hash::make($new_password);
            $save = self::userArrayUpdate($user_id, $user_data_update);

            if($save){
                app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'user', [
                    'th' => 'อัพเดทบัญชีผู้ใช้ ' . $request->input('username'),
                    'en' => 'Update a ' . $request->input('username') . ' user account.',
                ]);
                return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
            }else{
                return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
            }
        }
        
        $save = self::userArrayUpdate($user_id, $user_data_update);

        if($save){
            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'user', [
                'th' => 'อัพเดทบัญชีผู้ใช้ ' . $request->input('username'),
                'en' => 'Update a ' . $request->input('username') . ' user account.',
            ]);
            return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
        }else{
            return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
        }
    }

    public function userUpdateInPosone(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $validatedData = $request->validate([
            'user_id' => 'required',
            'username' => 'required|max:32',
            'password_status' => 'required',
            'first_name_edit' => 'required',
            'last_name_edit' => 'required',
            'phone_number_edit' => 'required',
        ]);

        $user_id = $request->input('user_id');
        
        $get_user = self::getUserAtPosone($request->input('username'));

        $user_check_posone = self::existsUserCheckAtPosone2($request->input('username')); //ถ้าโดนเลิกจ้างไปแล้ว ให้เป็นการสมัครใหม่
 
        if($user_check_posone){ //1 มีอยู่ / 0 ยังไม่มี //update at posone

            $emp_old = ($request->input('register_type') != null) ? $request->input('register_type') : 'no' ; //พนักงานที่เคยเลิกจ้าง 1(จ้างต่อ) 0(สร้างบัญชีใหม่)

            $data_image = [
                'hasFile' => $request->hasFile("image"),
                'file' => $request->file('image'),
                'id' => $user_id,
                'data_file' => $request->image,
                'type' => 2
            ];
            $image = self::uplodeImage($data_image);

            $user_data_update = array(
                'admin' => ($request->input('is_admin_edit') != null) ? 1 : 0,
                'employee' => $get_user->empCode,
                'sale' => ($request->input('is_sale_edit') != null) ? 1 : 0,
                'prefix' => $request->input('prefix_edit'),
                'first_name' => $request->input('first_name_edit'),
                'last_name' => $request->input('last_name_edit'),
                'tel' => $request->input('phone_number_edit'),
                'image' => $image,
                'updated_at' => date('Y-m-d H:i:s'),
            );

            if($emp_old == 'no' || $user_check_posone[0]->status == 'E'){ //update

                $validatedData = $request->validate([
                    'first_name_edit' => 'required',
                    'last_name_edit' => 'required',
                    'nick_name_edit' => 'required',
                    'citizenid_edit' => 'required',
                    'phone_number_edit' => 'required',
                    'address_edit' => 'required',
                ]);
        
                $reset_password_check = ($request->input('password_status') != '0');
                if($reset_password_check){
                    $validatedData = $request->validate([
                        'password' => 'min:8|required_with:password_confirm|same:password_confirm',
                        'password_confirm' => 'min:8'
                    ]);
                    $new_password = $request->input('password');
                    $user_data_update = array('password' => Hash::make($new_password));
                    $save = self::userArrayUpdate($user_id, $user_data_update);
                }
    
                $password = $reset_password_check ? $new_password : $get_user->password;
                $posone_user_data_update = [
                    'username' => $get_user->username,
                    'emp_code' => $get_user->empCode,
                    'password' => $password,
                    'prefix' => self::getPrefix($request->input('prefix_edit'))[1],
                    'nick_name' => $request->input('nick_name_edit'),
                    'status' => $request->input('status_edit'),
                    'address' => $request->input('address_edit'),
                    'created_date' => date('Y-m-d'),
                    'empPOSName' => self::getPrefix($request->input('prefix_edit'))[0] . '-' . $request->input('first_name_edit') . '-' . $request->input('last_name_edit'),
                    'empPOSPeopleId' => str_replace("-", "", $request->input('citizenid_edit')),
                    'empPOSTel' => str_replace("-", "", $request->input('phone_number_edit')),
                    'empPOSTaxId' => str_replace("-", "", $request->input('empPOSTaxId_edit')),
                    'empPOSReferName' => self::getPrefix($request->input('refer_prefix_edit'))[0] . '-' . $request->input('refer_first_name_edit'),
                    'empPOSReferSurName' => $request->input('refer_last_name_edit'),
                    'empPOSReferAddress' => $request->input('refer_address_edit'),
                ];
                self::userUpdateToPosone($posone_user_data_update, $reset_password_check);
    
                $save = self::userArrayUpdate($user_id, $user_data_update);
    
                if($save){
                    app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'user', [
                        'th' => 'อัพเดทบัญชีผู้ใช้ ' . $get_user->username,
                        'en' => 'Update a ' . $get_user->username . ' user account.',
                    ]);

                    return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
                }else{
                    return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
                }

            }elseif($emp_old == '1'){ //จ้างต่อ

                $reset_password_check = ($request->input('password_status') != '0');

                if($reset_password_check){
                    $validatedData = $request->validate([
                        'password' => 'min:8|required_with:password_confirm|same:password_confirm',
                        'password_confirm' => 'min:8'
                    ]);
                    $new_password = $request->input('password');
                    $user_data_update = array('password' => Hash::make($new_password));
                    $save = self::userArrayUpdate($user_id, $user_data_update);
                }

                self::Hire($get_user->empCode, $reset_password_check ? $new_password : $get_user->password); //จ้างต่อ

                $password = $reset_password_check ? $new_password : $get_user->password;
                $posone_user_data_update = [
                    'username' => $get_user->username,
                    'emp_code' => $get_user->empCode,
                    'password' => $password,
                    'prefix' => self::getPrefix($request->input('prefix_edit'))[1],
                    'nick_name' => $request->input('nick_name_edit'),
                    'status' => $request->input('status_edit'),
                    'address' => $request->input('address_edit'),
                    'created_date' => date('Y-m-d'),
                    'empPOSName' => self::getPrefix($request->input('prefix_edit'))[0] . '-' . $request->input('first_name_edit') . '-' . $request->input('last_name_edit'),
                    'empPOSPeopleId' => str_replace("-", "", $request->input('citizenid_edit')),
                    'empPOSTel' => str_replace("-", "", $request->input('phone_number_edit')),
                    'empPOSTaxId' => str_replace("-", "", $request->input('empPOSTaxId_edit')),
                    'empPOSReferName' => self::getPrefix($request->input('refer_prefix_edit'))[0] . '-' . $request->input('refer_first_name_edit'),
                    'empPOSReferSurName' => $request->input('refer_last_name_edit'),
                    'empPOSReferAddress' => $request->input('refer_address_edit'),
                ];
                self::userUpdateToPosone($posone_user_data_update, $reset_password_check);

                $user_data_update['employee'] = $get_user->empCode;
                $save = self::userArrayUpdate($user_id, $user_data_update);

                if($save){
                    app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'user', [
                        'th' => 'อัพเดทบัญชีผู้ใช้ ' . $get_user->username,
                        'en' => 'Update a ' . $get_user->username . ' user account.',
                    ]);

                    return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
                }else{
                    return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
                }
            }elseif($emp_old == '0'){ //สร้างบัญชีใหม่
                $emp_code = self::lastEmpCode();

                $user_edited_check = strpos($request->input('username'), "_");
                if($user_edited_check){
                    $arr_username = explode("_", $request->input('username'));
                    $username = $arr_username[0] . "_" . rand(10,99);
                }else{
                    $username = $request->input('username') . "_" . rand(10,99);
                }
                
                $posone_user_data_insert = [
                    'emp_code' => $emp_code,
                    'username' => $username,
                    'password' => $request->input('password'),
                    'prefix' => self::getPrefix($request->input('prefix_edit'))[1],
                    'nick_name' => $request->input('nick_name_edit'),
                    'status' => $request->input('status_edit'),
                    'address' => $request->input('address_edit'),
                    'created_date' => date('Y-m-d'),
                    'empPOSName' => self::getPrefix($request->input('prefix_edit'))[0] . '-' . $request->input('first_name_edit') . '-' . $request->input('last_name_edit'),
                    'empPOSPeopleId' => str_replace("-", "", $request->input('citizenid_edit')),
                    'empPOSTel' => str_replace("-", "", $request->input('phone_number_edit')),
                    'empPOSTaxId' => str_replace("-", "", $request->input('empPOSTaxId_edit')),
                    'empPOSReferName' => self::getPrefix($request->input('refer_prefix_edit'))[0] . '-' . $request->input('refer_first_name_edit'),
                    'empPOSReferSurName' => $request->input('refer_last_name_edit'),
                    'empPOSReferAddress' => $request->input('refer_address_edit'),
                ];
                self::userSaveToPosone($posone_user_data_insert);

                $new_password = $request->input('password');
                $user_data_update['password'] = Hash::make($new_password);
                $save = self::userArrayUpdate($user_id, $user_data_update);

                if($save){
                    app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'user', [
                        'th' => 'อัพเดทบัญชีผู้ใช้ ' . $username,
                        'en' => 'Update a ' . $username . ' user account.',
                    ]);

                    return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'Update and hire employees successfully.' : 'อัพเดทและจ้างพนักงาน สำเร็จ');
                }else{
                    return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
                }
            }

        }else{ //insert at posone

            $validatedData = $request->validate([
                'user_id' => 'required',
                'first_name_edit' => 'required',
                'last_name_edit' => 'required',
                'nick_name_edit' => 'required',
                'citizenid_edit' => 'required',
                'phone_number_edit' => 'required',
                'address_edit' => 'required',
                'username' => 'required|unique:userlogin|max:255',
                'password' => 'min:8|required_with:password_confirm|same:password_confirm',
                'password_confirm' => 'min:8'
            ]);

            $emp_code = self::lastEmpCode();
            $posone_user_data_insert = [
                'emp_code' => $emp_code,
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'prefix' => self::getPrefix($request->input('prefix_edit'))[1],
                'nick_name' => $request->input('nick_name_edit'),
                'status' => $request->input('status_edit'),
                'address' => $request->input('address_edit'),
                'created_date' => date('Y-m-d'),
                'empPOSName' => self::getPrefix($request->input('prefix_edit'))[0] . '-' . $request->input('first_name_edit') . '-' . $request->input('last_name_edit'),
                'empPOSPeopleId' => str_replace("-", "", $request->input('citizenid_edit')),
                'empPOSTel' => str_replace("-", "", $request->input('phone_number_edit')),
                'empPOSTaxId' => str_replace("-", "", $request->input('empPOSTaxId_edit')),
                'empPOSReferName' => self::getPrefix($request->input('refer_prefix_edit'))[0] . '-' . $request->input('refer_first_name_edit'),
                'empPOSReferSurName' => $request->input('refer_last_name_edit'),
                'empPOSReferAddress' => $request->input('refer_address_edit'),
            ];
            self::userSaveToPosone($posone_user_data_insert);

            $new_password = $request->input('password');
            $user_data_update['password'] = Hash::make($new_password);
            $user_data_update['employee'] = $emp_code;
            $save = self::userArrayUpdate($user_id, $user_data_update);

            if($save){
                return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'Update and successfully create employee accounts.' : 'อัพเดทและสร้างบัญชีพนักงาน สำเร็จ');
            }else{
                return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
            }
        }
    }

    public function existsUserCheckAtPosone($username)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from userlogin where username='".$username."'";

        $get_user = DB::select(DB::raw($qury));

        ($get_user != null && $get_user[0]->status != 'D') ? $result = $get_user[0]->status : $result = 0;

        return $result;
    }

    public function existsUserCheckAtPosone2($username)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from userlogin where username='".$username."'";

        $get_user = DB::select(DB::raw($qury));

        ($get_user != null) ? $result = $get_user : $result = 0;

        return $result;
    }

    public function getUserAtPosone($username)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from userlogin where username='".$username."'";

        $get_user = DB::select(DB::raw($qury));

        return ($get_user != null) ? $get_user[0] : '';
    }

    public function userSaveToPosone($data)
    {
        $qury = [
            "call sp_userlogin_insert (0, 1, '".$data['emp_code']."', '".$data['username']."', '".$data['password']."', 'E', '".$data['created_date']."', '', 'SINGLE')",
            "call sp_employeepos_insert (0, 1, NULL, '', '0', '0', '".$data['emp_code']."', '".$data['empPOSName']."', '".$data['nick_name']."', '".$data['created_date']."', 'BACK', '".$data['empPOSPeopleId']."', '', '', '".$data['prefix']."', '".$data['status']."', '".$data['address']."', '".$data['empPOSTel']."', '', '".$data['empPOSReferName']."', '".$data['empPOSReferSurName']."', '".$data['empPOSReferAddress']."', NULL, '00', '".$data['empPOSTaxId']."', 'SINGLE')",
        ];

        foreach ($qury as $item) {
            DB::select(DB::raw($item));
        }
    }

    public function userUpdateToPosone($data, $reset_password_check)
    {
        $qury = [
            "call sp_employeepos_update (0, 1, '', NULL, '0.0000', '0.0000', '".$data['emp_code']."', '".$data['empPOSName']."', '".$data['nick_name']."', '".$data['created_date']."', 'BACK', '".$data['empPOSPeopleId']."', '', '', '".$data['prefix']."', '".$data['status']."', '".$data['address']."', '".$data['empPOSTel']."', '', '".$data['empPOSReferName']."', '".$data['empPOSReferSurName']."', '".$data['empPOSReferAddress']."', NULL, '00', '".$data['empPOSTaxId']."')"
        ];
        
        // $call = "call sp_userlogin_update ('".$data['username']."', '".$data['password']."', 'E', '".$data['emp_code']."', 'SINGLE')";
        $call = "UPDATE userlogin SET password='".$data['password']."' WHERE empCode='".$data['emp_code']."'";

        if($reset_password_check) array_push($qury, $call);

        foreach ($qury as $item) {
            DB::select(DB::raw($item));
        }
    }

    public function LayOff($emp_code) //เลิกจ้าง
    {
        $call = "UPDATE userlogin SET status='D' WHERE empCode='".$emp_code."'";

        DB::select(DB::raw($call));
    }

    public function Hire($emp_code, $password) //เลิกต่อ
    {
        $call = "UPDATE userlogin SET status='E', password='".$password."' WHERE empCode='".$emp_code."'";

        DB::select(DB::raw($call));
    }

    public function storeSuspend(Request $request, $id)
    {
        $user_data_update = [
            'banned_until' => $request->input('date_ban'),
        ];

        $save = self::userArrayUpdate($id, $user_data_update);

        $user = $this->getUserData($id);

        if($save){
            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'user ban', [
                'th' => 'ระงับบัญชีผู้ใช้ ' . $user['name'],
                'en' => 'Suspend user ' . $user['name'] . ' account.',
            ]);

            return redirect()->route('adminUsers')->withsuccess((\Session::get('locale') != "th") ? 'The user account was successfully suspended.' : 'ระงับบัญชีผู้ใช้ สำเร็จ');
        }else{
            return redirect()->route('adminUsers')->with('fail', (\Session::get('locale') != "th") ? 'Failed to suspend the user account.' : 'ระงับบัญชีผู้ใช้ ไม่สำเร็จ');
        }
    }
}
