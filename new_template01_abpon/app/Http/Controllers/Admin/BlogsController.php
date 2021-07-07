<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Auth;

use App\Blog;

class BlogsController extends Controller
{
    public function index($text = null)
    {
      if($text != null){
        $blogs = Blog::collection('blogs')
        ->select('blogs.id as id','users.name as user_name','blogs.title as title','blogs.description as description','blogs.image as image','blogs.products as products')
        ->leftjoin('users','blogs.user_id','users.id')
        ->where('blogs.title' , 'like' , '%'.$text.'%' )
        ->orderby('blogs.id','desc')
        ->get();
      }else{
        $blogs = Blog::collection('blogs')
        ->select('blogs.id as id','users.name as user_name','blogs.title as title','blogs.description as description','blogs.image as image','blogs.products as products')
        ->leftjoin('users','blogs.user_id','users.id')
        ->where('blogs.id', '!=', 0)
        ->orderby('blogs.id','desc')
        ->get();
      }

      return view('login.admin.displayBlog', [
          'blogs' => $blogs,
          'text_search_blog' => $text
      ]);
    }

    public function searchBlog(Request $request)
    {
      return self::index($request->input('search'));
    }

    public function addBlog()
    {
        return view('login.admin.createBlog');
    }

    public function createBlog(Request $request)
    {
        Validator::make($request->all(), ['image.*' => "required|file|image|mimes:jpg,png,jpeg|max:5000"])->validate();

        $date = $request->input('date');
        // dd($date);
        if($date != null){
          $date_format = explode("-", $date);
          $day = $date_format[2];
          $month = self::month($date_format[1]);
        }else{
          return redirect()->route('addBlog')->with('fail', (\Session::get('locale') != "th") ? 'Save is not successful. Please select a date' : 'บันทึก ไม่สำเร็จ กรุณาเลือกวันที่');
        }
     
        // $date_format = explode("-", $date);

        // $day = $date_format[2];

        // $month = self::month($date_format[1]);
        
        if($request->hasFile('image'))
        {   
            $image =$request->image;

            $imageName = $image->getClientOriginalName();

            $imageEncoded = File::get($image);

            Storage::disk('local')->put('public/blog_images/'.$imageName, $imageEncoded);
        }

        $newBlogArray = array(
            'id' => Blog::database()->collection("blogs")->getModifySequence('id'),
            'user_id' => Auth::user()->id,
            'date' => [$day, array($date_format[1], $month), $date_format[0]],
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imageName,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $save = Blog::database()->collection("blogs")->insert($newBlogArray);

        if($save){
          app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'blog', [
              'th' => 'เพิ่มข่าวสาร ' . $request->input('title'),
              'en' => 'Successfully created ' . $request->input('title') . ' blog.',
          ]);

          return redirect()->route('adminBlogs')->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
        }else{
            return redirect()->route('adminBlogs')->with('fail', (\Session::get('locale') != "th") ? 'Save is not successful.' : 'บันทึก ไม่สำเร็จ');
        }
    }

    public function editBlog(Request $request, $id)
    {
      $blog = Blog::collection("blogs")->where('id',"=",$id*1)->first();

      $blog_id = Blog::collection('blogs')->select('id')->get();
    
      $array_id = [];
      foreach ($blog_id as $item) {
          array_push($array_id, $item['id']);
      }

      return view('login.admin.editBlog',[
          'blog' => $blog,
          'blog_id' => $array_id,
      ]);
    }

    public function updateBlog(Request $request, $id)
    {
      $date = $request->input('date');

      $date_format = explode("-", $date);

      $day = $date_format[2];

      $month = self::month($date_format[1]);

      $blog = DB::connection('mongodb')->collection("blogs")->select('image')->where('id','=',$id*1)->first();

      if($request->hasFile("image")){

        $image = $request->image;

        $exists = Storage::disk('local')->exists("public/blog_images/".$blog['image']);

        if($exists){
          Storage::delete('public/blog_images/'.$blog['image']);
        }

        $imageName = $image->getClientOriginalName();

        $imageEncoded = File::get($image);
            
        Storage::disk('local')->put('public/blog_images/'.$imageName, $imageEncoded);

      }

      $save = DB::connection('mongodb')->collection("blogs")
      ->where('id',"=",$id*1)
      ->update([
          'date' => [$day, array($date_format[1], $month), $date_format[0]],
          'title' => $request->input('title'),
          'description' => $request->input('description'),
          'image' => isset($imageName) ? $imageName : $blog['image'],
          'updated_at' => date('Y-m-d H:i:s')
        ]);

      if($save){
        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'blog', [
          'th' => 'อัพเดทข่าวสาร ' . $request->input('title'),
          'en' => 'Successfully updated ' . $request->input('title') . ' blog.',
        ]);

        return redirect()->route('adminBlogs')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
      }else{
        return redirect()->route('adminBlogs')->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
      }
    }

    public function deleteBlog($id)
    {
      $blog = Blog::collection("blogs")->where('id',"=",$id*1)->first();

      $exists = Storage::disk('local')->exists('public/blog_images/'.$blog[0]['image']);

      if($exists){
        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'error', 'blog', [
          'th' => 'ลบข่าวสาร ' . $blog[0]['title'],
          'en' => 'Successfully delete ' . $blog[0]['title'] . ' blog.',
        ]);

        Storage::disk('local')->delete('public/blog_images/'.$blog[0]['image']);

        DB::connection('mongodb')->collection("blogs")->where("id","=",$id*1)->delete();

        return back()->withsuccess((\Session::get('locale') != "th") ? 'Deleted successfully.' : 'ลบสำเร็จ');

      }else{

        return back()->with('fail', (\Session::get('locale') != "th") ? 'Failed to delete.' : 'ลบ ไม่สำเร็จ');
      }
    }

    public function month($m)
    {
      switch ($m) {
        case "01":
          return "มกราคม";
          break;
        case "02":
          return "กุมภาพันธ์";
          break;
        case "03":
          return "มีนาคม";
          break;
        case "04":
          return "เมษายน";
          break;
        case "05":
          return "พฤษภาคม";
          break;
        case "06":
          return "มิถุนายน";
          break;
        case "07":
          return "กรกฎาคม";
          break;
        case "08":
          return "สิงหาคม";
          break;
        case "09":
          return "กันยายน";
          break;
        case "10":
          return "ตุลาคม";
          break;
        case "11":
          return "พฤศจิกายน";
          break;
        case "12":
          return "ธันวาคม";
          break;
        default:
          return "error!";
      }
    }


}
