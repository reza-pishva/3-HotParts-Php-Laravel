<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Exit_goods_permission;
use App\Goodstype;
use App\Grouprole;
use App\Groupuser;
use App\Request_level;
use App\Role;
use App\User_role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class confirm2 extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create_second_reciever()
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
                if($role_name['role'] ==="admin" or $role_name['role'] ==="second_level_confirmation"){
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
                    return view('exitform_second_reciever',compact('goodstypes','date_shamsi','user','part','requests','mytime','full_name'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }
    public function level2()
    {
        $data = Exit_goods_permission::where('level',2)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
    public function level3()
    {
        $data = Exit_goods_permission::where('level',3)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
    public function level_3()
    {
        $data = Exit_goods_permission::where('level',-3)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
    public function level_2()
    {
        $data = Exit_goods_permission::where('level',-2)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function confirm2($id)
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
        $values = array('level' => 3,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول حراست:تایید درخواست توسط مسئول حراست");
        DB::table('workflows')->insert($values);
        //level->3
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>3]);
        //$body=Exit_goods_permission::where('id_exit', $id_exit)->first();
        //open page
//        $payload = array(
//            'to' => 'ExponentPushToken[zxM9aEKZ0xcKJ2q0xmnsNf]',
//            'sound' => 'default',
//            'body' => 'سلام',
//        );
//
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => json_encode($payload),
//            CURLOPT_HTTPHEADER => array(
//                "Accept: application/json",
//                "Accept-Encoding: gzip, deflate",
//                "Content-Type: application/json",
//                "cache-control: no-cache",
//                "host: exp.host"
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//            echo $response;
//        }















        return response()->json(['success'=> 'hi']);
    }
    public function archive($id)
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
        $level=DB::table('exit_goods_permissions')->where('id_exit', $id)->orderBy('id_exit', 'DESC')->first()->level;
        $level+=20;
            $id_user = auth()->user()->id;
            $values = array('level' => $level,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول حراست: ارسال درخواست به بایگانی موقت");
            DB::table('workflows')->insert($values);
            Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>$level]);
        return response()->json(['success'=> 'hi','level'=>$level]);
    }
    public function return_archive($id)
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
        $level=DB::table('exit_goods_permissions')->where('id_exit', $id)->orderBy('id_exit', 'DESC')->first()->level;
        $level-=20;
        $id_user = auth()->user()->id;
        $values = array('level' => $level,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول حراست:انتقال درخواست به کارتابل انتظامات");
        DB::table('workflows')->insert($values);
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>$level]);
        return response()->json(['success'=> 'hi','level'=>$level]);
    }
    public function show_archive()
    {
        $data = Exit_goods_permission::where('level','>',20)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
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
        $reason1=$request->input('reason2');

        Exit_goods_permission::where('id_exit', $id_exit)->update(['reason2'=>$reason1,'level'=>-2]);
        $id_user = auth()->user()->id;
        $values = array('level' => -2,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول حراست:عدم تایید درخواست توسط مسئول حراست");
        DB::table('workflows')->insert($values);
        $values = array('level' => -2,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$reason1);
        DB::table('workflows')->insert($values);
        return response()->json(['success'=>'the information has successfuly saved','result',$id_exit]);

    }
    public function to_kartabl($id)
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

        //inserting workflow updating request_level
        $id_user = auth()->user()->id;
        $values = array('level' => 2,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول حراست:بازگرداندن درخواست به کارتابل خود توسط مسئول حراست");
        DB::table('workflows')->insert($values);
        //level->2
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>2]);
        //open page
        return response()->json(['success'=> 'hi']);
    }
    public function not_confirmed_boss()
    {
        $data = Exit_goods_permission::where('level', -2)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes,'users'=>$data3]);
    }
}
