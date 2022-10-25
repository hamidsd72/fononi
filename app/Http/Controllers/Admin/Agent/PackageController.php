<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Models\AgentLevel;
use App\Models\AgentPackage;
use App\Models\Activity;
use App\Models\FilePhoto;
use App\Models\FileArchive;
use App\Http\Requests\Agent\PackageRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PackageController extends Controller
{
    public function controller_title($type)
    {
        switch ($type) {
            case 'index':
                return 'لیست پکیج ها';
                break;
            case 'create':
                return 'افزودن پکیج';
                break;
            case 'edit':
                return 'ویرایش پکیج';
                break;
            case 'url_back':
                return route('admin.agent-package.index');
                break;
            default:
                return '';
                break;
        }
    }

    public function __construct()
    {
        $this->middleware('permission:agent_package_list', ['only' => ['index', 'show']]);
        $this->middleware('permission:agent_package_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:agent_package_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:agent_package_delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = AgentPackage::orderByDesc('id')->get();
        return view('admin.agent.package.index', compact('items'), ['title' => $this->controller_title('index')]);
    }

    public function show($id)
    {
    }

    public function create()
    {
        $url_back = $this->controller_title('url_back');
        $levels=AgentLevel::orderBy('sort')->get();
        return view('admin.agent.package.create', compact('url_back','levels'), ['title' => $this->controller_title('create')]);
    }

    public function store(PackageRequest $request)
    {
        try {
            $item = AgentPackage::create([
                'level_id' => $request->input('level_id'),
                'title' => $request->input('title'),
                'text' => $request->input('text'),
                'price' => $request->input('price'),
                'price_type' => $request->input('price_type'),
                'test_condition' => $request->input('test_condition'),
                'status_fa' => $request->input('status_fa'),
                'status_ar' => $request->input('status_ar'),
                'status_en' => $request->input('status_en'),
                'create_user_id' => auth()->id(),
            ]);
            //added  photo
            if ($request->hasFile('photo'))
            {
                $address=file_store($request->photo, "assets/uploads/agent/package/" . g2j(date('Y/m/d'), 'Y-m-d') . "/pic/", 'pic-');;
                $photo=new FilePhoto();
                $photo->type='photo';
                $photo->path = $address;
                $item->photo()->save($photo);
            }
            //added  archive
            if ($request->hasFile('archive'))
            {
                $address=file_store($request->archive, "assets/uploads/agent/package/" . g2j(date('Y/m/d'), 'Y-m-d') . "/archive/", 'pic-');;
                $archive=new FileArchive();
                $archive->type='archive';
                $archive->path = $address;
                $item->archive()->save($archive);
            }
            //store lang
            store_lang($request,'agent_package',$item->id,['title','text']);
            //store report
            $activity = new Activity();
            $activity->user_id = Auth::user()->id;
            $activity->type = 'store';
            $activity->text = ' پکیج نمایندگی : ' . '(' . $item->title . ')' . ' را ثبت کرد';
            $item->activity()->save($activity);

            return redirect($this->controller_title('url_back'))->with('flash_message', 'اطلاعات با موفقیت افزوده شد');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'برای افزودن به مشکل خوردیم، مجدد تلاش کنید');
        }
    }

    public function edit($id)
    {
        $url_back = $this->controller_title('url_back');
        $item = AgentPackage::findOrFail($id);
        $levels=AgentLevel::orderBy('sort')->get();
        $title=$this->controller_title('edit').' '.$item->title;
        return view('admin.agent.package.edit', compact('url_back', 'item','levels'), ['title' => $title]);
    }

    public function update(PackageRequest $request, $id)
    {
        $item = AgentPackage::findOrFail($id);;
        try {
            $item->level_id = $request->input('level_id');
            $item->title = $request->input('title');
            $item->text = $request->input('text');
            $item->price = $request->input('price');
            $item->price_type = $request->input('price_type');
            $item->test_condition = $request->input('test_condition');
            $item->status_fa = $request->input('status_fa');
            $item->status_ar = $request->input('status_ar');
            $item->status_en = $request->input('status_en');
            $item->update();

            //added  photo
            if ($request->hasFile('photo'))
            {
                file_remove($item,'out','photo');
                $address=file_store($request->photo, "assets/uploads/agent/package/" . g2j(date('Y/m/d'), 'Y-m-d') . "/pic/", 'pic-');;
                $photo=new FilePhoto();
                $photo->type='photo';
                $photo->path = $address;
                $item->photo()->save($photo);
            }
            //added  archive
            if ($request->hasFile('archive'))
            {
                file_remove($item,'out','archive');
                $address=file_store($request->archive, "assets/uploads/agent/package/" . g2j(date('Y/m/d'), 'Y-m-d') . "/archive/", 'pic-');;
                $archive=new FileArchive();
                $archive->type='archive';
                $archive->path = $address;
                $item->archive()->save($archive);
            }
            //store lang
            if(count($item->langs))
            {
                foreach ($item->langs as $lang){
                    $lang->delete();
                }
            }
            store_lang($request,'agent_package',$item->id,['title','text']);
            //store report
            $activity = new Activity();
            $activity->user_id = Auth::user()->id;
            $activity->type = 'update';
            $activity->text = ' پکیج نمایندگی : ' . '(' . $item->title . ')' . ' را ویرایش کرد';
            $item->activity()->save($activity);
            return redirect($this->controller_title('url_back'))->with('flash_message', 'اطلاعات با موفقیت ویرایش شد');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'برای ویرایش به مشکل خوردیم، مجدد تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = AgentPackage::findOrFail($id);
        $old_title=$item->title;
        try {
            $item->delete();

            //store report
            $activity = new Activity();
            $activity->user_id = Auth::user()->id;
            $activity->type = 'delete';
            $activity->text = ' پکیج نمایندگی : ' . '(' . $old_title . ')' . ' را حذف کرد';
            $item->activity()->save($activity);
            return redirect($this->controller_title('url_back'))->with('flash_message', 'اطلاعات با موفقیت حذف شد');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'برای حذف به مشکل خوردیم، مجدد تلاش کنید');
        }
    }

}
