<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Models\UserAgent;

use App\Http\Controllers\Controller;

class AgentController extends Controller
{ 
    public function controller_title($type)
    {
        switch ($type) {
            case 'index':
                return 'درخواست های نمایندگی';
                break;
            case 'show':
                return 'درخواست نمایندگی';
                break;
        }
    }

    public function index() 
    {
        $items  = UserAgent::orderByDesc('id')->get();
        return view('admin.user.agent.index', compact('items'), ['title' => $this->controller_title('index')]);
    }

    public function show($id)
    {
        // find item
        $item  = UserAgent::findOrFail($id);
        // active item
        $item->seen = 'yes';
        $item->save();
        // find country name
        $item->country_code = \App\Models\CountryCode::where('phone_code', $item->country_code)->first()->title;
        return view('admin.user.agent.show', compact('item'), ['title' => $this->controller_title('show')]);
    }

}
