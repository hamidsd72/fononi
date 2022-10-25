<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Models\AgentLevel;
use App\Models\Activity;
use App\Http\Requests\Agent\LevelRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class LevelController extends Controller
{
    public function controller_title($type)
    {
        switch ($type) {
            case 'index':
                return 'لیست لول نمایندگان';
                break;
            case 'create':
                return 'افزودن لول';
                break;
            case 'edit':
                return 'ویرایش لول';
                break;
            case 'url_back':
                return route('admin.agent-level.index');
                break;
            default:
                return '';
                break;
        }
    }

    public function __construct()
    {
        $this->middleware('permission:agent_level_list', ['only' => ['index', 'show']]);
        $this->middleware('permission:agent_level_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:agent_level_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:agent_level_delete', ['only' => ['destroy']]);
        $this->middleware('permission:agent_level_sort', ['only' => ['sort']]);
    }

    public function index()
    {
        $items = AgentLevel::orderByDesc('sort')->get();
        return view('admin.agent.level.index', compact('items'), ['title' => $this->controller_title('index')]);
    }

    public function show($id)
    {
    }

    public function create()
    {
        $url_back = $this->controller_title('url_back');
        return view('admin.agent.level.create', compact('url_back'), ['title' => $this->controller_title('create')]);
    }

    public function store(LevelRequest $request)
    {
        try {
            $item = AgentLevel::create([
                'title' => $request->input('title'),
                'sort' => AgentLevel::count()+1,
                'text' => $request->input('text'),
                'discount_percent' => $request->input('discount_percent'),
                'partnership_percent' => $request->input('partnership_percent'),
                'entry_condition' => $request->input('entry_condition'),
                'settlement_condition' => $request->input('settlement_condition'),
                'award_condition' => $request->input('award_condition'),
                'award_num_show' => $request->input('award_num_show'),
                'num_test' => $request->input('num_test'),
                'price_test' => $request->input('price_test'),
                'extra_percent_test' => $request->input('extra_percent_test'),
                'price_type' => $request->input('price_type'),
                'status' => $request->input('status'),
                'create_user_id' => auth()->id(),
            ]);
            //store lang
            store_lang($request,'agent_level',$item->id,['title','text']);
            //store report
            $activity = new Activity();
            $activity->user_id = Auth::user()->id;
            $activity->type = 'store';
            $activity->text = ' لول نمایندگی : ' . '(' . $item->title . ')' . ' را ثبت کرد';
            $item->activity()->save($activity);

            return redirect($this->controller_title('url_back'))->with('flash_message', 'اطلاعات با موفقیت افزوده شد');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'برای افزودن به مشکل خوردیم، مجدد تلاش کنید');
        }
    }

    public function edit($id)
    {
        $url_back = $this->controller_title('url_back');
        $item = AgentLevel::findOrFail($id);

        $title=$this->controller_title('edit').' '.$item->title;
        return view('admin.agent.level.edit', compact('url_back', 'item'), ['title' => $title]);
    }

    public function update(LevelRequest $request, $id)
    {
        $item = AgentLevel::findOrFail($id);;
        try {
            $item->title = $request->input('title');
            $item->text = $request->input('text');
            $item->discount_percent = $request->input('discount_percent');
            $item->partnership_percent = $request->input('partnership_percent');
            $item->entry_condition = $request->input('entry_condition');
            $item->settlement_condition = $request->input('settlement_condition');
            $item->award_condition = $request->input('award_condition');
            $item->award_num_show = $request->input('award_num_show');
            $item->num_test = $request->input('num_test');
            $item->price_test = $request->input('price_test');
            $item->extra_percent_test = $request->input('extra_percent_test');
            $item->price_type = $request->input('price_type');
            $item->status = $request->input('status');
            $item->update();

            //store lang
            if(count($item->langs))
            {
                foreach ($item->langs as $lang){
                    $lang->delete();
                }
            }
            store_lang($request,'agent_level',$item->id,['title','text']);
            //store report
            $activity = new Activity();
            $activity->user_id = Auth::user()->id;
            $activity->type = 'update';
            $activity->text = ' لول نمایندگی : ' . '(' . $item->title . ')' . ' را ویرایش کرد';
            $item->activity()->save($activity);
            return redirect($this->controller_title('url_back'))->with('flash_message', 'اطلاعات با موفقیت ویرایش شد');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'برای ویرایش به مشکل خوردیم، مجدد تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = AgentLevel::findOrFail($id);
        $old_title=$item->title;
        try {
            if(count($item->packages))
            {
                return redirect()->back()->withInput()->with('err_message', 'برای حذف باید ابتدا پکیج های مربوط به لول را حذف کنید');
            }
            $item->delete();

            //store report
            $activity = new Activity();
            $activity->user_id = Auth::user()->id;
            $activity->type = 'delete';
            $activity->text = ' لول نمایندگی : ' . '(' . $old_title . ')' . ' را حذف کرد';
            $item->activity()->save($activity);
            return redirect($this->controller_title('url_back'))->with('flash_message', 'اطلاعات با موفقیت حذف شد');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'برای حذف به مشکل خوردیم، مجدد تلاش کنید');
        }
    }
    public function sort($id,Request $request)
    {
        $item = AgentLevel::findOrFail($id);
        $old_title=$item->title;
        try {
            $check_item=AgentLevel::where('sort',$request->sort)->first();
            if($check_item)
            {
                return redirect()->back()->withInput()->with('err_message', 'ترتیب ها نباید تکراری باشد');
            }
            $item->sort=$request->sort;
            $item->update();

            //store report
            $activity = new Activity();
            $activity->user_id = Auth::user()->id;
            $activity->type = 'update';
            $activity->text = ' لول نمایندگی : ' . '(' . $old_title . ')' . ' را مرتب کرد';
            $item->activity()->save($activity);
            return redirect($this->controller_title('url_back'))->with('flash_message', 'اطلاعات با موفقیت مرتب شد');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'برای مرتب سازی به مشکل خوردیم، مجدد تلاش کنید');
        }
    }

}
