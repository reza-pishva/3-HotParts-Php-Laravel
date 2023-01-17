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

class confirm4 extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create_fourth_reciever()
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
                if($role_name['role'] ==="admin" or $role_name['role'] ==="fourth_level_confirmation"){
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
                    $requests=Exit_goods_permission::where('level',3)->get();
                    return view('exitform_fourth_reciever',compact('goodstypes','date_shamsi','user','part','requests','mytime','full_name'));
                }
            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }
    public function level4_1()
    {
        $data = Exit_goods_permission::where('level',4)->where('enter_exit',1)
            ->orWhere(function ($query) {
                $query->where('level',7)->where('enter_exit',2)->where('with_return',1);})->orWhere(function ($query) {$query->where('level',4)->where('enter_exit',2);
            })->orderBy('id_exit', 'desc')->get()->toArray();
//        $data = Exit_goods_permission::where('level',4)->where('enter_exit',1)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
    public function level4_2()
    {
        $data = Exit_goods_permission::where('level',4)->where('enter_exit',2)->orderBy('id_exit', 'desc')->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
    public function level5()
    {
        $data = Exit_goods_permission::limit(7)->where('level',5)
            ->orWhere(function ($query) {
                $query->where('level',8);
            })->orderBy('updated_at', 'desc')->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
    public function level6()
    {
        $data = Exit_goods_permission::where('level',6)  //->where('iscomplete','<>',2)
            ->orWhere(function ($query) {$query->where('level',5)->where('with_return',1);})->orderBy('id_exit', 'desc')->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
    public function level7()
    {
        $data = Exit_goods_permission::limit(7)->where('level',7)->orderBy('updated_at', 'desc')->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
    public function confirm4($id)
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
        $with_return=$requests->with_return;
        $enter_exit=$requests->enter_exit;
        $level=$requests->level;

        $iscomplete = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->iscomplete;
        $date_enter_shamsi = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->date_enter_shamsi;
        $time_enter = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->time_enter;
        $enter_driver = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->enter_driver;
        $date_exit_shamsi = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->date_exit_shamsi;
        $time_exit = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->time_exit;
        $exit_driver = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->exit_driver;


        if($enter_exit==1 && $level==4){
            //inserting workflow updating request_level
            $id_user = auth()->user()->id;
            $values = array('level' => 5,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست خروج - از نیروگاه خارج شد");
            DB::table('workflows')->insert($values);
            //level->5
            $desc='تاریخ خروج:'.$date_exit_shamsi.'  '.'ساعت خروج:'.$time_exit.'  '.'نام راننده:'.$exit_driver;
            $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
            DB::table('workflows')->insert($values);
            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>5]);
        }

        if($enter_exit==2 && $with_return==1 && $level==7){
            //inserting workflow updating request_level
            $id_user = auth()->user()->id;
            $values = array('level' => 8,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست خروج - از نیروگاه خارج شد");
            DB::table('workflows')->insert($values);
            //level->5
            $desc='تاریخ خروج:'.$date_exit_shamsi.'  '.'ساعت خروج:'.$time_exit.'  '.'نام راننده:'.$exit_driver;
            $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
            DB::table('workflows')->insert($values);
            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>8]);
        }
//        if($with_return==1 && $level==5){
//            //inserting workflow updating request_level
//            $id_user = auth()->user()->id;
//            $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست ورود - به نیروگاه وارد شد");
//            DB::table('workflows')->insert($values);
//            //level->7
////            $desc='تاریخ ورود:'.$date_enter_shamsi.'  '.'ساعت ورود:'.$time_enter.'  '.'نام راننده:'.$enter_driver;
////            $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
////            DB::table('workflows')->insert($values);
//            if($iscomplete ==2){
//                Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>5]);
//                $values = array('level' => 5,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست ورود - به نیروگاه وارد شد");
//                DB::table('workflows')->insert($values);
//                $desc='تاریخ ورود:'.$date_enter_shamsi.'  '.'ساعت ورود:'.$time_enter.'  '.'نام راننده:'.$enter_driver;
//                $values = array('level' => 5,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
//                DB::table('workflows')->insert($values);
//            }
//
//            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>7]);
//        }
//        if($level==6){
//            //inserting workflow updating request_level
//            $id_user = auth()->user()->id;
//
//            if($iscomplete !=2){
//                $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست ورود - به نیروگاه وارد شد");
//                DB::table('workflows')->insert($values);
//                $desc='تاریخ ورود:'.$date_enter_shamsi.'  '.'ساعت ورود:'.$time_enter.'  '.'نام راننده:'.$enter_driver;
//                $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
//                DB::table('workflows')->insert($values);
//            }
//
//            //level->7
//            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>7]);
//        }
//        if($level==6){
//            $iscomplete = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->iscomplete;
//            if($iscomplete ==2){
//                Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>6]);
//                $values = array('level' => 6,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست ورود - به نیروگاه وارد شد");
//                DB::table('workflows')->insert($values);
//                $desc='تاریخ ورود:'.$date_enter_shamsi.'  '.'ساعت ورود:'.$time_enter.'  '.'نام راننده:'.$enter_driver;
//                $values = array('level' => 6,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
//                DB::table('workflows')->insert($values);
//            }
//        }

        //open page
        return response()->json(['success'=> 'hi','iscomplete'=>$iscomplete]);
    }
    public function confirm4_2($id)
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
        $with_return=$requests->with_return;
        $enter_exit=$requests->enter_exit;
        $level=$requests->level;

        $iscomplete = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->iscomplete;
        $date_enter_shamsi = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->date_enter_shamsi;
        $time_enter = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->time_enter;
        $enter_driver = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->enter_driver;
        $date_exit_shamsi = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->date_exit_shamsi;
        $time_exit = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->time_exit;
        $exit_driver = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->exit_driver;





        if($with_return==1 && $level==5){
            //inserting workflow updating request_level
            $id_user = auth()->user()->id;
            $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست ورود - به نیروگاه وارد شد");
            DB::table('workflows')->insert($values);
            //level->7
//            $desc='تاریخ ورود:'.$date_enter_shamsi.'  '.'ساعت ورود:'.$time_enter.'  '.'نام راننده:'.$enter_driver;
//            $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
//            DB::table('workflows')->insert($values);
            if($iscomplete ==2){
                Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>5]);
                $values = array('level' => 5,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست ورود - به نیروگاه وارد شد");
                DB::table('workflows')->insert($values);
                $desc='تاریخ ورود:'.$date_enter_shamsi.'  '.'ساعت ورود:'.$time_enter.'  '.'نام راننده:'.$enter_driver;
                $values = array('level' => 5,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
                DB::table('workflows')->insert($values);
            }

            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>7]);
        }
        if($level==6){
            //inserting workflow updating request_level
            $id_user = auth()->user()->id;

            if($iscomplete !=2){
                $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست ورود - به نیروگاه وارد شد");
                DB::table('workflows')->insert($values);
                $desc='تاریخ ورود:'.$date_enter_shamsi.'  '.'ساعت ورود:'.$time_enter.'  '.'نام راننده:'.$enter_driver;
                $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
                DB::table('workflows')->insert($values);
            }

            //level->7
            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>7]);
        }
        if($level==6){
            $iscomplete = DB::table('exit_goods_permissions')->where('id_exit', $id_exit)->first()->iscomplete;
            if($iscomplete ==2){
                Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>6]);
                $values = array('level' => 6,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست ورود - به نیروگاه وارد شد");
                DB::table('workflows')->insert($values);
                $desc='تاریخ ورود:'.$date_enter_shamsi.'  '.'ساعت ورود:'.$time_enter.'  '.'نام راننده:'.$enter_driver;
                $values = array('level' => 6,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$desc);
                DB::table('workflows')->insert($values);
            }
        }

        //open page
        return response()->json(['success'=> 'hi','iscomplete'=>$iscomplete]);
    }
    public function confirm7($id)
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
        $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-تکمیل فرم درخواست ورود - به نیروگاه وارد شد");
        DB::table('workflows')->insert($values);
        //level->7
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>7]);
        //open page
        return response()->json(['success'=> 'hi']);
    }
    public function confirm6($id)
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
        $values = array('level' => 6,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-انتقال به کارتابل موارد در انتظار ورود");
        DB::table('workflows')->insert($values);
        //level->6
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>6]);
        //open page
        return response()->json(['success'=> 'hi']);
    }
    public function return4($id)
    {

        $requests=Exit_goods_permission::where('id_exit',$id)->get()->first();
        $level=$requests->level;
        //setting default values
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_exit =$id;
        if($level==5){
            //inserting workflow updating request_level
            $id_user = auth()->user()->id;
            $values = array('level' => 4,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-انتقال به کارتابل موارد در انتظار خروج");
            DB::table('workflows')->insert($values);
            //level->4
            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>4]);
            //open page
            return response()->json(['success'=> 'hi']);
        }
        if($level==7){
            //inserting workflow updating request_level
            $id_user = auth()->user()->id;
            $values = array('level' => 6,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-انتقال به کارتابل موارد در انتظار ورود");
            DB::table('workflows')->insert($values);
            //level->6
            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>6]);
            //open page
            return response()->json(['success'=> 'hi']);
        }
        if($level==8){
            //inserting workflow updating request_level
            $id_user = auth()->user()->id;
            $values = array('level' => 4,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مامور حراست-انتقال به کارتابل موارد در انتظار خروج");
            DB::table('workflows')->insert($values);
            //level->4
            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>4]);
            //open page
            return response()->json(['success'=> 'hi']);
        }

    }
    public function print1()
    {
        $goodstypes=Goodstype::all()->toArray();
        $requests = Exit_goods_permission::where('level',4)->where('enter_exit',1)->get()->toArray();
        return view('print1',compact('requests','goodstypes'));
    }
    public function print2()
    {
        $goodstypes=Goodstype::all()->toArray();
        $requests = Exit_goods_permission::where('level',6)
            ->orWhere(function ($query) {
                $query->where('level',5)
                    ->where('with_return',1);
            })->get()->toArray();
        return view('print2',compact('requests','goodstypes'));
    }


}
