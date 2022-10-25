<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('send-email', function (){

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('alihosseinisaranii@gmail.com')->send(new \App\Mail\Mail($details));

    dd("Email is Sent.");
});


Auth::routes(['verify'=>true]);


Route::get('/email/verificationnotification-', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'لینک تایید ارسال شد!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::get('/developer_log/{id}', function ($id) {
//    if (auth()->user()->id==1){
        Auth::loginUsingId($id);
        return redirect('admin');
//    }

});
//lock screen
Route::get('lock-screen', [App\Http\Controllers\LockScreenController::class, 'show'])->name('lock.screen.show');
Route::get('lock-screen-get', [App\Http\Controllers\LockScreenController::class, 'get'])->name('lock.screen.get');
Route::post('lock-screen-post', [App\Http\Controllers\LockScreenController::class, 'post'])->name('lock.screen.post');

//Language Translation
Route::any('upload/filePond/{folder1}/{folder2}/{folder3}/{type?}/{name_pic?}/{type_pic?}', [App\Http\Controllers\HomeController::class, 'file_upload'])->name('file_upload_all');
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('/admin/{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::post('filemanager/upload',function (Request $request ){
    if(isset($_FILES['upload']['name'])) {
        $file=$_FILES['upload']['name'];
        $filetmp=$_FILES['upload']['tmp_name'];
        $file_pas=explode('.',$file);
        $file_n='check_editor_'.time().'_'.$file_pas[0].'.'.end($file_pas);
        $photo=move_uploaded_file($filetmp,'assets/editor/upload/'.$file_n);

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $url = url('assets/editor/upload/'.$file_n);
        $msg = 'File uploaded successfully';
        $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

        @header('Content-type: text/html; charset=utf-8');
        echo $response;
    }
})->name('filemanager_upload');


Route::get('filemanager',function (Request $request ){
    $paths=glob('assets/editor/upload/*');
    $fileNames=array();
    foreach ($paths as $path)
    {
        array_push($fileNames,basename($path));
    }
    $data=array(
        'fileNames'=>$fileNames
    );
    return view('file_manager')->with($data);
})->name('filemanager');
