<?php
//مدیر نیروگاه
namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Enteringform;
use App\Enteringpeaple;
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

class confirm2_entering extends Controller
{
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
                if($role_name['role'] ==="admin" or $role_name['role'] ==="powerplant_manager_confirmation_entering"){
                    $allow=1;
                    $g_y = Carbon::now()->year;
                    $g_m = Carbon::now()->month;
                    $g_d = Carbon::now()->day;
                    $Calendar=new CalendarHelper();
                    $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                    $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                    $mytime=Carbon::now();
                    $part = auth()->user()->id_request_part;
                    $requests=Enteringform::where('level',2)->get();
                    return view('entering_peaple.enterform_second_reciever',compact('date_shamsi','user','part','requests','mytime','full_name'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }

    public function level5()
    {
        $data = Enteringform::where('level',5)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function level6()
    {
        $data = Enteringform::where('level',6)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function level3()
    {
        $data = Enteringform::where('level',3)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
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
        $id_ef =$id;
        //inserting workflow updating request_level
        $id_user = auth()->user()->id;
        $values = array('level' => 6,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مدیر نیروگاه:تایید درخواست توسط مدیر نیروگاه و ارسال برای انتظامات");
        DB::table('workflows')->insert($values);
        //level->6
        Enteringform::where('id_ef', $id_ef)->update(['level'=>6]);
        Enteringpeaple::where('id_ef', $id_ef)->update(['let_show'=>1]);
        //send sms
//        require '/vendor/autoload.php';
//        $sender = "1000596446";
//        $receptor = array("09171168741");
//        $message = ".وب سرویس پیام کوتاه کاوه نگار";
//        $api = new \Kavenegar \KavenegarApi("584B583939464D4679356E44654C3854615A754644323956726E31776359446E33503252385678785966513D");
//        $api -> Send ( $sender,$receptor,$message);
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

        $id_ef=$request->input('id_ef2');
        $reason3=$request->input('reason3');
        Enteringform::where('id_ef', $id_ef)->update(['reason3'=>$reason3,'level'=>-5]);
        Enteringpeaple::where('id_ef', $id_ef)->update(['let_show'=>0]);
        $id_user = auth()->user()->id;
        $values = array('level' => -5,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مدیر نیروگاه:عدم تایید درخواست توسط مدیر نیروگاه");
        DB::table('workflows')->insert($values);
        $values = array('level' => -5,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$reason3);
        DB::table('workflows')->insert($values);

        return response()->json(['success'=>'the information has successfuly saved','result',$id_ef]);

    }
    public function to_kartabl5($id)
    {
        //setting default values
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_ef =$id;
        //inserting workflow updating request_level
        $id_user = auth()->user()->id;
        $values = array('level' => 5,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مدیر نیروگاه:بازگرداندن درخواست به کارتابل خود توسط مدیر نیروگاه");
        DB::table('workflows')->insert($values);
        //level->2
        Enteringform::where('id_ef', $id_ef)->update(['level'=>5]);
        Enteringpeaple::where('id_ef', $id_ef)->update(['let_show'=>0]);
        //open page
        return response()->json(['success'=> 'hi']);
    }
    public function not_confirmed_boss()
    {
        $data = Enteringform::where('level', -5)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }

}
