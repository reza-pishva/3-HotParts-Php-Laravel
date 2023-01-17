<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Enteringform;
use App\Enteringhefazat;
use App\Enteringpeaple;
use App\Enteringtitle;
use App\Grouprole;
use App\Groupuser;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class confirm_imeni_entering extends Controller
{
    public function create_imeni_reciever()
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
                if($role_name['role'] ==="admin" or $role_name['role'] ==="imeni_level_confirmation_entering"){
                    $allow=1;
                    $g_y = Carbon::now()->year;
                    $g_m = Carbon::now()->month;
                    $g_d = Carbon::now()->day;
                    $Calendar=new CalendarHelper();
                    $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                    $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                    $mytime=Carbon::now();
                    $part = auth()->user()->id_request_part;
                    $requests=Enteringform::where('level',3)->get();
                    return view('entering_peaple.enterform_imeni_reciever',compact('date_shamsi','user','part','requests','mytime','full_name'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }

    public function persons($id)
    {
        $titles=Enteringtitle::all();
        $persons = DB::table('enteringpeaples')->where('id_ef',$id)->get()->toArray();
        return response()->json(['results'=> $persons,'titles'=> $titles]);
    }

    public function level2()
    {
        $data = Enteringform::limit(5)->where('level',2)->orderBy('id_ef','desc')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function herasatboss()
    {
        $data = Enteringform::limit(5)->where('level',4)->orderBy('id_ef','desc')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function not_confirmed_boss()
    {
        $data = Enteringform::limit(5)->where('level', -3)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
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
        $id_ef =$id;
        //inserting workflow updating request_level
        $id_user = auth()->user()->id;
        $values = array('level' => 4,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"ایمنی:ارسال درخواست توسط واحد ایمنی و ارسال برای سرپرست حراست");
        DB::table('workflows')->insert($values);
        //level->2
        Enteringform::where('id_ef', $id_ef)->update(['level'=>4]);

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
    public function updatecondition(Request $request)
    {
        $id_ep=$request->input('id_ep2');
        $cond4=$request->input('cond41');
        $cond5=$request->input('cond51');
        if($cond4==null){$cond4=0;}
        if($cond5==null){$cond5=0;}
        Enteringhefazat::where('id_ep',$id_ep)->where('part',1)->delete();
        $id_ef = DB::table('enteringpeaples')->where('id_ep',$id_ep)->orderBy('id_ep', 'DESC')->first()->id_ef;
        if($cond4==1){
            $description=' در بدو ورود خودرو یا نفر با اداره ايمني و آتش نشاني هماهنگي نموده و پس از حضور ايمني وارد نيروگاه شوند';
            $values = array('id_ef' =>$id_ef,'id_ep' =>$id_ep,'description' => $description,'part'=>1);
            DB::table('enteringhefazats')->insert($values);
        }
        if($cond5==1){
            $description='جهت آموزش نكات ايمني به اداره ايمني و آتش نشاني مراجعه نمايد';
            $values = array('id_ef' =>$id_ef,'id_ep' =>$id_ep,'description' => $description,'part'=>1);
            DB::table('enteringhefazats')->insert($values);
        }
        Enteringpeaple::where('id_ep', $id_ep)->update(['cond4'=>$cond4,'cond5'=>$cond5]);
        return response()->json(['success'=>'the information has successfuly saved','id_ef'=>$id_ef,'id_ep'=>$id_ep,'cond4'=>$cond4,'cond5'=>$cond5]);
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
        $id_ef =$id;
        //inserting workflow updating request_level
        $id_user = auth()->user()->id;
        $values = array('level' => 2,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"ایمنی:بازگرداندن درخواست به کارتابل خود توسط مسئول ایمنی");
        DB::table('workflows')->insert($values);
        //level->2
        Enteringform::where('id_ef', $id_ef)->update(['level'=>2]);
        //open page
        return response()->json(['success'=> 'hi']);
    }



}
