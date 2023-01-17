<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Exit_goods_permission;
use App\Goodstype;
use App\Grouprole;
use App\Groupuser;
use App\Request_level;
use App\Role;
use App\User;
use App\User_role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class confirm3 extends Controller
{
    public function create_third_reciever()
    {
        //--access level-----
        $user = auth()->user()->id;
        $f_name=auth()->user()->f_name;
        $l_name=auth()->user()->l_name;
        $full_name=$f_name.' '.$l_name;
        $groupusers=Groupuser::where('id_user',$user)->get()->toArray();
        $allow=0;
        foreach ($groupusers as $groupuser) {
            $grouproles=Grouprole::where('id_gr',$groupuser['id_gr'])->get()->toArray();
            foreach ($grouproles as $grouprole) {

                $role_name=Role::where('id_role',$grouprole['id_role'])->first();
                if($role_name['role'] ==="admin" or $role_name['role'] ==="third_level_confirmation"){
                    $allow=1;
                    $goodstypes=Goodstype::all();
                    $g_y = Carbon::now()->year;
                    $g_m = Carbon::now()->month;
                    $g_d = Carbon::now()->day;
                    $Calendar=new CalendarHelper();
                    $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                    $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                    $mytime=Carbon::now();
                    $part = auth()->user()->id_request_part;
                    $requests=Exit_goods_permission::where('level',2)->get();
                    return view('exitform_third_reciever',compact('goodstypes','date_shamsi','user','part','requests','mytime','full_name'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }

    public function level4()
    {
        $data = Exit_goods_permission::where('level',4)->orWhere('level',6)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
    public function level3()
    {
        $data = Exit_goods_permission::where('level',3)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'reza'=>$data3]);
    }
    public function confirm_req1($id)
    {

        Exit_goods_permission::where('id_exit', $id)->update(['level'=>600]);
        return response()->json(['results'=> $id]);
    }
    public function notconfirm_req1($id,$reason3)
    {

        Exit_goods_permission::where('id_exit', $id)->update(['level'=>-3]);
        Exit_goods_permission::where('id_exit', $id)->update(['reason3'=>$reason3]);
        return response()->json(['results'=> $id]);
    }

    public function confirm3($id)
    {
        $requests=Exit_goods_permission::where('id_exit',$id)->get()->first();
        //setting default values
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_exit =$id;
        $enter_exit=$requests->enter_exit;
        if($enter_exit==1){
            //inserting workflow updating request_level
            $id_user = auth()->user()->id;
            $values = array('level' => 4,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مدیر نیروگاه:تایید درخواست توسط مدیر نیروگاه");
            DB::table('workflows')->insert($values);
            //level->4
            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>4]);

        }
        if($enter_exit==2){
            //inserting workflow updating request_level

            //level->6
            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>6]);
            $id_user = auth()->user()->id;
            $values = array('level' => 6,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مدیر نیروگاه:تایید درخواست توسط مدیر نیروگاه");
            DB::table('workflows')->insert($values);
        }


        //open page
        return response()->json(['success'=> 'hi']);
    }
    public function returnform(Request $request)
    {
        //setting default values
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];

        $id_exit=$request->input('id_exit2');
        $reason1=$request->input('reason3');
        Exit_goods_permission::where('id_exit', $id_exit)->update(['reason3'=>$reason1,'level'=>-3]);

        $id_user = auth()->user()->id;
        $values = array('level' => -3,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مدیر نیروگاه:عدم تایید درخواست توسط مدیر نیروگاه");
        DB::table('workflows')->insert($values);
        $values = array('level' => -3,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$reason1);
        DB::table('workflows')->insert($values);

        return response()->json(['success'=>'the information has successfuly saved','result',$id_exit]);

    }
    public function to_kartabl($id)
    {
        //setting default values
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_exit =$id;
        //inserting workflow updating request_level
        $id_user = auth()->user()->id;
        $values = array('level' => 3,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مدیر نیروگاه:بازگرداندن درخواست به کارتابل خود توسط مدیر نیروگاه");
        DB::table('workflows')->insert($values);
        //level->3
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>3]);
        //open page
        return response()->json(['success'=> 'hi']);
    }

}
