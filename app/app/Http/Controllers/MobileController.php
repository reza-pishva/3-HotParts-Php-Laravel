<?php

namespace App\Http\Controllers;
use App\Enteringform;
use App\CalendarHelper;
use App\Car;
use App\Exit_goods_permission;
use App\Goodstype;
use App\Grouprole;
use App\Groupuser;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileController extends Controller
{
    public function amar1()
    {
        return view('main_guard3');
    }
    public function amar2()
    {
        return view('main_guard4');
    }
    public function level3()
    {
        $data = Exit_goods_permission::where('level',3)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level4()
    {
        $data = Exit_goods_permission::where('level',4)->orWhere('level',6)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level_3_mob_eq()
    {
        $data = Exit_goods_permission::where('level',-3)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level22_mob()
    {
        $data = Exit_goods_permission::where('level',2)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level_2_mob()
    {
        $data = Exit_goods_permission::where('level',-2)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level1_mob_eq($part)
    {
        $data = Exit_goods_permission::where('id_request_part', $part)->where('level',1)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level2_mob_eq()
    {
        $data = Exit_goods_permission::where('level',2)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level2p_mob_eq($part)
    {
        $data = Exit_goods_permission::where('level',2)->where('id_request_part', $part)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level_2p_mob_eq($part)
    {
        $data = Exit_goods_permission::where('level',-2)->where('id_request_part', $part)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level_2_mob_eq($part)
    {
        $data = Exit_goods_permission::where('id_request_part', $part)->where('level',-2)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function level_1_mob_eq($part)
    {
        $data = Exit_goods_permission::where('id_request_part', $part)->where('level',-1)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function goodstotal_mob_eq()
    {
        $goods=Goodstype::all();
        return response()->json(['goods'=> $goods]);
    }
    public function confirm_req1_mob_eq($id)
    {
        Exit_goods_permission::where('id_exit', $id)->update(['level'=>4]);
        return response()->json(['results'=> $id]);
    }
    public function notconfirm_req1_mob_eq($id,$reason3)
    {
        Exit_goods_permission::where('id_exit', $id)->update(['level'=>-3]);
        Exit_goods_permission::where('id_exit', $id)->update(['reason3'=>$reason3]);
        return response()->json(['results'=> $id]);
    }
    public function to_kartabl3_mob_eq($id)
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_exit =$id;
        $values = array('level' => 3,'id_exit' =>$id_exit,'id_user' => 0,'date_shamsi' => $date_shamsi,'description' =>"مدیر نیروگاه:بازگشت به کارتابل");
        DB::table('workflows')->insert($values);
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>3]);
        return response()->json(['success'=> 'hi']);
    }
    public function notconfirm_req2_mob_eq($id,$reason2)
    {
        Exit_goods_permission::where('id_exit', $id)->update(['level'=>-2]);
        Exit_goods_permission::where('id_exit', $id)->update(['reason2'=>$reason2]);
        return response()->json(['results'=> $id]);
    }
    public function to_kartabl2_mob_eq($id)
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_exit =$id;
        $values = array('level' => 2,'id_exit' =>$id_exit,'id_user' => 0,'date_shamsi' => $date_shamsi,'description' =>"مسئول حراست: بازگشت به کارتابل");
        DB::table('workflows')->insert($values);
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>2]);
        return response()->json(['success'=> 'hi']);
    }
    public function confirm_req2_mob_eq($id)
    {
        Exit_goods_permission::where('id_exit', $id)->update(['level'=>3]);
        return response()->json(['results'=> $id]);
    }
    public function confirm_req3_mob_eq($id)
    {
        Exit_goods_permission::where('id_exit', $id)->update(['level'=>2]);
        return response()->json(['results'=> $id]);
    }
    public function notconfirm_req3_mob_eq($id,$reason3)
    {
        Exit_goods_permission::where('id_exit', $id)->update(['level'=>-1]);
        Exit_goods_permission::where('id_exit', $id)->update(['reason1'=>$reason3]);
        return response()->json(['results'=> $id]);
    }
    public function to_kartabl1_mob_eq($id)
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_exit =$id;
        $values = array('level' => 1,'id_exit' =>$id_exit,'id_user' => 0,'date_shamsi' => $date_shamsi,'description' =>"مسئول مستقیم:بازگشت به کارتابل");
        DB::table('workflows')->insert($values);
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>1]);
        return response()->json(['success'=> 'hi']);
    }
    public function level_22_mob_eq($part)
    {
        $data = Exit_goods_permission::where('id_request_part', $part)->where('level',-2)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }



















    // public function level1_mob($part)
    // {
    //     $data = Exit_goods_permission::where('id_request_part', $part)->where('level',1)->get()->toArray();
    //     $goodstypes=Goodstype::all()->toArray();
    //     return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    // }
    // public function level_1_mob($part)
    // {
    //     $data = Exit_goods_permission::where('id_request_part', $part)->where('level',-1)->get()->toArray();
    //     $goodstypes=Goodstype::all()->toArray();
    //     return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    // }






    public function getuserinfo($user,$pass)
    {
        $valid=DB::table('users')->where('name','=',$user)->where('plain_pass','=',$pass)->get()->toArray();
        $id=DB::table('users')->where('name','=',$user)->first()->id;
        $part=DB::table('users')->where('name','=',$user)->first()->id_request_part;
        $groupusers=DB::table('groupusers')->where('id_user','=',$id)->get()->toArray();
        return response()->json(['group'=>$groupusers,'valid'=>count($valid),'part'=>$part]);
    }

    public function confirm_req2($id)
    {
        Exit_goods_permission::where('id_exit', $id)->update(['level'=>3]);
        return response()->json(['results'=> $id]);
    }









    public function level2_mob_pe($part)
    {
        $data = Enteringform::where('level',2)->where('id_request_part',$part)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function level_1_mob_pe($part)
    {
        $data = Enteringform::where('level',-1)->where('id_request_part',$part)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function level_4_mob_pe($part)
    {
        $data = Enteringform::where('level',-4)->where('id_request_part',$part)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function level_4_mob_5pe()
    {
        $data = Enteringform::where('level',-4)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function level_3_mob_pe()
    {
        $data = Enteringform::where('level',3)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function level_5_mob_pe()
    {
        $data = Enteringform::where('level',5)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function level_7_mob_pe()
    {
        $data = Enteringform::where('level',4)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function level_n5_mob_pe()
    {
        $data = Enteringform::where('level',-5)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function level_6_mob_pe()
    {
        $data = Enteringform::where('level',6)->get()->toArray();
        return response()->json(['results'=> $data]);
    }


    public function confirm_req1_pe_mob($id)
    {
        Enteringform::where('id_ef', $id)->update(['level'=>2]);
        return response()->json(['results'=> $id]);
    }
    public function confirm_req4_pe_mob($id)
    {
        Enteringform::where('id_ef', $id)->update(['level'=>6]);
        return response()->json(['results'=> $id]);
    }
    public function confirm_req5_pe_mob($id)
    {
        Enteringform::where('id_ef', $id)->update(['level'=>5]);
        return response()->json(['results'=> $id]);
    }


    public function notconfirm_req1_pe($id,$reason1)
    {
        Enteringform::where('id_ef', $id)->update(['level'=>-1]);
        Enteringform::where('id_ef', $id)->update(['reason1'=>$reason1]);
        return response()->json(['results'=> $id]);
    }
    public function notconfirm_req4_pe($id,$reason1)
    {
        Enteringform::where('id_ef', $id)->update(['level'=>-5]);
        Enteringform::where('id_ef', $id)->update(['reason3'=>$reason1]);
        return response()->json(['results'=> $id]);
    }
    public function notconfirm_req5_pe($id,$reason1)
    {
        Enteringform::where('id_ef', $id)->update(['level'=>-4]);
        Enteringform::where('id_ef', $id)->update(['reason2'=>$reason1]);
        return response()->json(['results'=> $id]);
    }


    public function to_kartabl1_pe($id)
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_ef =$id;
        $values = array('level' => 1,'id_exit' =>$id_ef+1000000,'id_user' => 0,'date_shamsi' => $date_shamsi,'description' =>"مسئول مستقیم:بازگشت به کارتابل");
        DB::table('workflows')->insert($values);
        Enteringform::where('id_ef', $id)->update(['level'=>1]);
        return response()->json(['success'=> 'hi']);
    }
    public function to_kartabl4_pe($id)
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_ef =$id;
        $values = array('level' => 4,'id_exit' =>$id_ef+1000000,'id_user' => 0,'date_shamsi' => $date_shamsi,'description' =>"مدیر حراست: بازگشت به کارتابل ");
        DB::table('workflows')->insert($values);
        Enteringform::where('id_ef', $id)->update(['level'=>4]);
        return response()->json(['success'=> 'hi']);
    }
    public function to_kartabl5_pe($id)
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_ef =$id;
        $values = array('level' => 5,'id_exit' =>$id_ef+1000000,'id_user' => 0,'date_shamsi' => $date_shamsi,'description' =>"مدیر نیروگاه: بازگشت به کارتابل");
        DB::table('workflows')->insert($values);
        Enteringform::where('id_ef', $id)->update(['level'=>5]);
        return response()->json(['success'=> 'hi']);
    }
}
