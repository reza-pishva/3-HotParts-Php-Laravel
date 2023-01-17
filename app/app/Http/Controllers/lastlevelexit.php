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

class lastlevelexit extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function lastlevelexit()
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
                $requests=Exit_goods_permission::where('level',4)->get();
                $goodstypes=Goodstype::all();
                return view('lastlevelexit',compact('requests','goodstypes'));
            }
        }
        if($allow===0){
            return view('access_denied');
        }
        //--access level-----
    }
    public  function lastdetailexit($id){
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
        $request=Exit_goods_permission::where('level',4)->where('id_exit',$id)->first();
        return view('lastdetailexit',compact('mytime','user','date_shamsi','cars','id','request'));
    }
    public  function exitupdate(Request $request){
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $mytime=Carbon::now();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];

        //level->5 or level->6
        if($request->with_return==1){
            Exit_goods_permission::where('id_exit',$request->id_exit)->update(['time_exit'=>$request->time_exit,'date_exit_shamsi'=>$request->date_shamsi,'date_exit_miladi'=>$request->date_exit_miladi,'id_herasat_exit'=>$request->id_herasat_exit,'exit_timestamp'=>$request->exit_timestamp,'id_car'=>$request->id_car,'level'=>5]);
        //inserting workflow updating request_level
            $values = array('level' => 5,'id_exit' =>$request->id_exit,'id_request_part' =>$request->id_request_part,'id_requester' =>$request->id_requester,'date_shamsi' =>$request->date_shamsi,'date_time' => $mytime,'time_stamp' => $mytime->timestamp);
            DB::table('workflows')->insert($values);
            Request_level::where('id_exit', $request->id_exit)->update(['level'=>5]);
        }
        if($request->with_return==2){
            Exit_goods_permission::where('id_exit',$request->id_exit)->update(['time_exit'=>$request->time_exit,'date_exit_shamsi'=>$request->date_shamsi,'date_exit_miladi'=>$request->date_exit_miladi,'id_herasat_exit'=>$request->id_herasat_exit,'exit_timestamp'=>$request->exit_timestamp,'id_car'=>$request->id_car,'level'=>6]);
        //inserting workflow updating request_level
            $values = array('level' => 6,'id_exit' =>$request->id_exit,'id_request_part' =>$request->id_request_part,'id_requester' =>$request->id_requester,'date_shamsi' =>$request->date_shamsi,'date_time' => $mytime,'time_stamp' => $mytime->timestamp);
            DB::table('workflows')->insert($values);
            Request_level::where('id_exit', $request->id_exit)->update(['level'=>6]);
        }
        //open page
        $requests=Exit_goods_permission::where('level',4)->get();
        $goodstypes=Goodstype::all();
        return view('lastlevelexit',compact('requests','goodstypes','date_shamsi'));
    }
}
