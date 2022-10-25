<?php

namespace App\Http\Controllers\Front\Agent;

use App\Models\User;
use App\Models\UserAgent;
use App\Models\UserAgentLang;
use App\Models\AgentLevel;
use App\Models\Marital;
use App\Models\EducationList;
use App\Models\StatusJob;
use App\Models\ListLang;
use App\Models\Introduction;
use App\Models\CountryCode;
use App\Models\FileArchive;
use App\Models\FilePhoto;
use App\Models\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AgentRegisterController extends Controller
{ 
    public function index()
    {
        $status = 'status_' . app()->getLocale();
        $maritals = Marital::where($status,'active')->get();
        $educations = EducationList::where($status,'active')->get();
        $status_jobs = StatusJob::where($status,'active')->get();
        $list_langs = ListLang::where($status,'active')->get();
        $introductions = Introduction::where($status,'active')->get();
        $country_codes = CountryCode::where($status,'active')->get();
        $user=null;
        if(Auth::check())
        {
            $user=Auth::user();
        }
        return view('front.agent.register.index', compact('maritals','educations','status_jobs','list_langs','introductions','country_codes','user'), ['title' => 'درخواست نمایندگی']);
    }
    public function store(Request $request)
    {
        $level=AgentLevel::where('status','active')->orderBy('sort')->firstOrFail();
        $status_job = StatusJob::findOrFail($request->job_status_id);
        //validate
        if(Auth::check())
        {
            $user=Auth::user();
            $request->validate([
                'photo_profile' => $user->photo_profile?'nullable|mimes:jpeg,jpg,png|max:5120':'required|mimes:jpeg,jpg,png|max:5120',
                'sex' => 'required',
                'age' => 'required',
                'marital_id' => 'required',
                'n_code' => 'required|numeric',
                'education_id' => 'required',
                'job_status_id' => 'required',
                'job_other' => $status_job->text_other=='yes'?'required|max:250':'nullable|max:250',
                'country_code' => 'required',
                'mobile' => 'required|numeric',
                'phone' => 'required|numeric',
                'website' => 'nullable|url',
                'address' => 'required',
                'postcode' => 'nullable|numeric',
                'social' => 'required',
                'lang_id.*' => 'required',
                'dominance.*' => 'required',
                'skill' => 'nullable|max:400',
                'award' => 'nullable|max:400',
                'Income_before' => 'nullable|max:250',
                'Income_after' => 'nullable|max:250',
                'sale_experience' => 'required',
                'property' => 'nullable|max:400',
                'strength_big' => 'required|max:400',
                'weakness_big' => 'required|max:400',
                'reasons' => 'required|max:400',
                'year_5_after' => 'nullable|max:400',
                'introduction_id' => 'required',
                'video' => 'nullable|url',
                'cv_file' => 'nullable|max:30720',
            ]);
        }
        else
        {
            $request->validate([
                'name' => 'required|max:250',
                'email' => 'required|email|max:255|unique:users',
                'username' => 'required|alpha_dash|string|min:3|max:20|unique:users',
                'password' => 'required|min:6|confirmed',
                'photo_profile' => 'required|mimes:jpeg,jpg,png|max:5120',
                'sex' => 'required',
                'age' => 'required|min:10|max:100',
                'marital_id' => 'required',
                'n_code' => 'required|numeric',
                'education_id' => 'required',
                'job_status_id' => 'required',
                'job_other' => $status_job->text_other=='yes'?'required|max:250':'nullable|max:250',
                'country_code' => 'required',
                'mobile' => 'required|numeric',
                'phone' => 'required|numeric',
                'website' => 'nullable|url',
                'address' => 'required',
                'postcode' => 'nullable|numeric',
                'social' => 'required',
                'lang_id.*' => 'required',
                'dominance.*' => 'required',
                'skill' => 'nullable|max:400',
                'award' => 'nullable|max:400',
                'Income_before' => 'nullable|max:250',
                'Income_after' => 'nullable|max:250',
                'sale_experience' => 'required',
                'property' => 'nullable|max:400',
                'strength_big' => 'required|max:400',
                'weakness_big' => 'required|max:400',
                'reasons' => 'required|max:400',
                'year_5_after' => 'nullable|max:400',
                'introduction_id' => 'required',
                'video' => 'nullable|url',
                'cv_file' => 'nullable|max:3720',
            ]);
        }
        try{
            if(!Auth::check())
            {
                $user=new User();
                $user->name=$request->name;
                $user->email=$request->email;
                $user->username=$request->username;
                $user->password=$request->password;
                $user->save();
            }
            $item=new UserAgent();
            //info اطلاعات شخصی
            $item->user_id=$user->id;
            $item->level_id=$level->id;
            $item->sex=$request->sex;
            $item->age=$request->age;
            $item->marital_id=$request->marital_id;
            $item->n_code=$request->n_code;
            $item->education_id=$request->education_id;
            $item->job_status_id=$request->job_status_id;
            $item->job_other=$status_job->text_other=='yes'?$request->job_other:null;
            //contact اطلاعات تماسی
            $item->country_code=$request->country_code;
            $item->mobile=$request->mobile;
            $item->phone=$request->phone;
            $item->email=$user->email;
            $item->website=$request->website;
            $item->address=$request->address;
            $item->postcode=$request->postcode;
            $item->social=$request->social;
            //skill مهارت
            $item->skill=$request->skill;
            $item->award=$request->award;
            //question سوالات
            $item->Income_before=$request->Income_before;
            $item->Income_after=$request->Income_after;
            $item->sale_experience=$request->sale_experience;
            $item->property=$request->property;
            $item->strength_big=$request->strength_big;
            $item->weakness_big=$request->weakness_big;
            $item->reasons=$request->reasons;
            $item->year_5_after=$request->year_5_after;
            $item->introduction_id=$request->introduction_id;
            $item->text=$request->text;
            //file
            $item->video=$request->video;
            $item->save();

            //added  lang list
            if ($request->lang_id[0])
            {
                foreach ($request->lang_id as $key=>$value)
                {
                    $lang=new UserAgentLang();
                    $lang->user_id=$user->id;
                    $lang->agent_id=$item->id;
                    $lang->lang_id=$value;
                    $lang->dominance=$request->dominance[$key];
                    $lang->save();
                }
            }
            //added  cv_file
            if ($request->hasFile('cv_file'))
            {
                $address=file_store($request->cv_file, "assets/uploads/user/agent/" . g2j(date('Y/m/d'), 'Y-m-d') . "/cv_file/", 'file-');;
                $cv_file=new FileArchive();
                $cv_file->type='cv_file';
                $cv_file->path = $address;
                $item->cv_file()->save($cv_file);
            }
            //added  photo_profile
            if ($request->hasFile('photo_profile'))
            {
                file_remove($user,'out','photo_profile');
                $address=file_store($request->photo_profile, "assets/uploads/user/user/" . g2j(date('Y/m/d'), 'Y-m-d') . "/pic/", 'pic-');;
                $photo=new FilePhoto();
                $photo->type='photo_profile';
                $photo->path = $address;
                $user->photo_profile()->save($photo);
            }

            //store report
            $activity = new Activity();
            $activity->user_id = Auth::user()->id;
            $activity->type = 'store';
            $activity->text = 'فرم نمایندگی : ' . '(' . Auth::user()->name . ')' . ' را ثبت کرد';
            $item->activity()->save($activity);

            return redirect()->route('front.job-offer.level.package')->with('flash_message', 'اطلاعات با موفقیت ثبت شد');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with('err_message', 'برای ثبت مراحل ارزیابی به مشکل خوردیم، مجدد تلاش کنید');
        }
    }

}
