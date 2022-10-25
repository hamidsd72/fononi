<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use App\Models\UserJobFixer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobFixerController extends Controller
{
    public function controller_title($type)
    {
        switch ($type) {
            case 'index':
                return 'لیست کاربران(ارزیابی)';
                break;
            default:
                return '';
                break;
        }
    }

    public function __construct()
    {
        $this->middleware('permission:user_job_fixer_list', ['only' => ['index']]);
    }

    public function index()
    {
        $items = UserJobFixer::orderByDesc('id')->get();
        return view('admin.user.job_fixer.index', compact('items'), ['title' => $this->controller_title('index')]);
    }


}
