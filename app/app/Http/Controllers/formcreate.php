<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Exit_goods_permission;
use App\Form;
use App\Goodstype;
use App\Grouprole;
use App\Groupuser;
use App\Role;
use App\User_role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class formcreate extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function changepass()
    {
        return view('changepass2');
    }
    public function create()
    {
        //--access level-----
        $user = auth()->user()->id;
        $groupusers=Groupuser::where('id_user',$user)->get()->toArray();
        $allow=0;
        foreach ($groupusers as $groupuser) {
            $grouproles=Grouprole::where('id_gr',$groupuser['id_gr'])->get()->toArray();
            foreach ($grouproles as $grouprole) {

                $role_name=Role::where('id_role',$grouprole['id_role'])->first();
                if($role_name['role'] ==="admin" or $role_name['role'] ==="request_sending"){
                    $allow=1;
                    $user = auth()->user()->id;
                    $g_y = Carbon::now()->year;
                    $g_m = Carbon::now()->month;
                    $g_d = Carbon::now()->day;
                    $Calendar=new CalendarHelper();
                    $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                    $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                    $mytime=Carbon::now();
                    $part = auth()->user()->id_request_part;
                    $goodstypes=Goodstype::all();
                    $requests=Exit_goods_permission::where('id_requester',$user)->where('level',1)->get();
                    return view('formcreate',compact('goodstypes','date_shamsi','user','part','requests','mytime'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }
    public function store(Request $request)
    {
        Form::create($request->except('_token'));
        $user = auth()->user()->id;
        $forms=Form::where('id_requester',$user)->orderBy('id_form', 'DESC')->first();
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $mytime=Carbon::now();
        $part = auth()->user()->id_request_part;
        $goodstypes=Goodstype::all();
        $requests=Exit_goods_permission::where('id_requester',$user)->where('level',1)->get();
        return view('exitformpublic',compact('goodstypes','date_shamsi','user','part','requests','mytime','forms'));
    }
}
