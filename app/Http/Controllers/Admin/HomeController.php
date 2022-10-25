<?php

namespace App\Http\Controllers\Admin;

use App\Models\FilePhoto;
use App\Models\FileVideo;
use App\Models\FileArchive;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Spatie\Permission\Models\Permission;
class HomeController extends Controller
{
    public function read_notification()
    {
        try {
            $user = Auth::user();
            foreach ($user->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
            return 'ok';
        } catch (\Exception $e) {
            return 'no';
        }
    }
    public function delete_file($type,$id)
    {
        try {
           if($type=='photo')
           {
               $item=FilePhoto::find($id);
           }
           elseif($type=='video')
           {
               $item=FileVideo::find($id);
           }
           elseif($type=='archive')
           {
               $item=FileArchive::find($id);
           }
           if(!$item)
           {
               return ['status'=>'not','msg'=>'فایل مورد نظر یافت نشد'];
           }
           if(is_file($item->path))
           {
               File::delete($item->path);
           }
           $item->delete();
            return ['status'=>'ok','msg'=>'با موفقیت حذف شد'];
        } catch (\Exception $e) {
            return ['status'=>'not','msg'=>'مشکلی در حذف رخ داده است'];
        }
    }
    public function index()
    {
        return view('admin.index');
    }
}
