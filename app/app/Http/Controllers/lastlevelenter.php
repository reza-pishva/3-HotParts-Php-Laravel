<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Car;
use App\Exit_goods_permission;
use App\Goodstype;
use App\Request_level;
use App\Role;
use App\User_role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class lastlevelenter extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function lastlevelenter()
    {
        //--access level-----
        $user = auth()->user()->id;
        $userroles =User_role::where('id_user',$user)->get();
        $allow=0;
        foreach ($userroles as $userrole) {
            $role=Role::where('id_role',$userrole['id_role'])->get();
            $role_name=$role[0]['role'];
            if($role_name ==="admin" or $role_name ==="last_level_processing"){
                $allow=1;
                $requests=Exit_goods_permission::where('level',5)->where('with_return',1)->get();
                $goodstypes=Goodstype::all();
                return view('lastlevelenter',compact('requests','goodstypes'));
            }
        }
        if($allow===0){
            return view('access_denied');
        }
        //--access level-----

    }
    public  function lastdetailenter($id){
        //setting default value
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $user = auth()->user()->id;
        $mytime=Carbon::now();
        //open page
        $cars=Car::all();
        $request=Exit_goods_permission::where('level',5)->where('id_exit',$id)->first();
        return view('lastdetailenter',compact('mytime','user','date_shamsi','cars','id','request'));
    }
    public  function enterupdate(Request $request){

        $mytime=Carbon::now();
        //level->7
        Exit_goods_permission::where('id_exit',$request->id_exit)->update(['time_enter'=>$request->time_enter,'enter_no'=>$request->enter_no,'date_enter_shamsi'=>$request->date_enter_shamsi,'date_enter_miladi'=>$request->date_enter_miladi,'id_herasat_enter'=>$request->id_herasat_enter,'enter_timestamp'=>$request->enter_timestamp,'id_car_enter'=>$request->id_car_enter,'level'=>7]);
        //inserting workflow updating request_level
        $values = array('level' => 7,'id_exit' =>$request->id_exit,'id_request_part' =>$request->id_request_part,'id_requester' =>$request->id_requester,'date_shamsi' =>$request->date_shamsi,'date_time' => $mytime,'time_stamp' => $mytime->timestamp);
        DB::table('workflows')->insert($values);
        Request_level::where('id_exit', $request->id_exit)->update(['level'=>7]);
        //open page
        $requests=Exit_goods_permission::where('level',5)->get();
        $goodstypes=Goodstype::all();
        return view('lastlevelenter',compact('requests','goodstypes'));
    }
}
