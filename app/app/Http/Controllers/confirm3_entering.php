<?php
//مدیر حراست
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

class confirm3_entering extends Controller
{
    public function level4()
    {
        $data = Enteringform::limit(5)->where('level',4)->orderBy('id_ef','desc')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function level5()
    {
        $data = Enteringform::limit(5)->where('level',5)->orderBy('id_ef','desc')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function level3_3()
    {
        $data = Enteringform::limit(5)->where('level', -3)->orWhere('level',-4)->orderBy('id_ef','desc')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function total_peaple()
    {
        $data = Enteringform::limit(100000)->where('level', 6)->orderBy('id_ef','desc')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }

    public function create_third_reciever()
    {
        //--access level-----
        $persons=Enteringtitle::all();
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
                if($role_name['role'] ==="admin" or $role_name['role'] ==="second_level_confirmation_entering"){
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
                    return view('entering_peaple.enterform_third_reciever2',compact('date_shamsi','user','part','requests','mytime','full_name','persons'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }
    public function report1()
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
                if($role_name['role'] ==="admin" or $role_name['role'] ==="second_level_confirmation_entering" or $role_name['role'] ==="powerplant_manager_confirmation_entering" or $role_name['role'] ==="gaurd_level_confirmation_entering" or $role_name['role'] ==="imeni_level_confirmation_entering"){
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
                    return view('entering_peaple.enteringform_report1',compact('date_shamsi','user','part','requests','mytime','full_name'));
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
    public function level1()
    {
        $data = Enteringform::limit(5)->where('level',4)->orderBy('id_ef','desc')->get()->toArray();
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
        $values = array('level' => 5,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مدیر حراست:تایید درخواست توسط مدیر حراست و ارسال برای مدیر نیروگاه");
        DB::table('workflows')->insert($values);
        //level->2
        Enteringform::where('id_ef', $id_ef)->update(['level'=>5]);
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
        $reason2=$request->input('reason2');
        $part_reciever=$request->input('part_reciever');

        if($part_reciever==1){
            Enteringform::where('id_ef', $id_ef)->update(['reason2'=>$reason2,'level'=>-3]);
        }
        if($part_reciever==2){
            Enteringform::where('id_ef', $id_ef)->update(['reason2'=>$reason2,'level'=>-4]);
        }


        $id_user = auth()->user()->id;
        $values = array('level' => -3,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول حراست:عدم تایید درخواست توسط مسئول حراست");
        DB::table('workflows')->insert($values);
        $values = array('level' => -3,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$reason2);
        DB::table('workflows')->insert($values);

        return response()->json(['success'=>'the information has successfuly saved','result',$id_ef]);

    }
    public function updatecondition(Request $request)
    {
        $id_ep=$request->input('id_ep2');
        $cond1=$request->input('cond11');
        $cond2=$request->input('cond21');
        $cond3=$request->input('cond31');
        $cond4=$request->input('cond41');
        $cond5=$request->input('cond51');
        $cond6=$request->input('cond61');
        $cardno=$request->input('cardno');
        if($cond1==null){$cond1=0;}
        if($cond2==null){$cond2=0;}
        if($cond3==null){$cond3=0;}
        if($cond4==null){$cond4=0;}
        if($cond5==null){$cond5=0;}
        if($cond6==null){$cond6=0;}
        Enteringhefazat::where('id_ep',$id_ep)->where('part',2)->delete();
        $id_ef = DB::table('enteringpeaples')->where('id_ep',$id_ep)->orderBy('id_ep', 'DESC')->first()->id_ef;
        if($cond1==1){
            $description='كارت مهمان/بازديد تحويل شود';
            $values = array('id_ef' =>$id_ef,'id_ep' =>$id_ep,'description' => $description,'part'=>2);
            DB::table('enteringhefazats')->insert($values);
        }
        if($cond2==1){
            $description='برگه تاييد ميزبان صادر شود';
            $values = array('id_ef' =>$id_ef,'id_ep' =>$id_ep,'description' => $description,'part'=>2);
            DB::table('enteringhefazats')->insert($values);
        }
        if($cond3==1){
            $description='توسط پرسنل حفاظت فيزيكي همراهي شود';
            $values = array('id_ef' =>$id_ef,'id_ep' =>$id_ep,'description' => $description,'part'=>2);
            DB::table('enteringhefazats')->insert($values);
        }
//        if($cond4==1){
//            $description=' در بدو ورود خودرو با اداره ايمني و آتش نشاني هماهنگي نموده و پس از حضور ايمني وارد نيروگاه شوند';
//            $values = array('id_ef' =>$id_ef,'id_ep' =>$id_ep,'description' => $description,'part'=>1);
//            DB::table('enteringhefazats')->insert($values);
//        }
//        if($cond5==1){
//            $description='جهت آموزش نكات ايمني به اداره ايمني و آتش نشاني مراجعه نمايد';
//            $values = array('id_ef' =>$id_ef,'id_ep' =>$id_ep,'description' => $description);
//            DB::table('enteringhefazats')->insert($values);
//        }
        if($cond6==1){
            $description='فرم ورود وسايل الكترونيكي/تجهيزات عملياتي صادر شود';
            $values = array('id_ef' =>$id_ef,'id_ep' =>$id_ep,'description' => $description,'part'=>2);
            DB::table('enteringhefazats')->insert($values);
        }
//        if($cond1==1 || $cond2==1 || $cond3==1 || $cond4==1 || $cond5==1 || $cond6==1){
//            Enteringpeaple::where('id_ep', $id_ep)->update(['let_show'=>1]);
//        }
//        else{
//            Enteringpeaple::where('id_ep', $id_ep)->update(['let_show'=>0]);
//        }
        Enteringpeaple::where('id_ep', $id_ep)->update(['cond1'=>$cond1,'cond2'=>$cond2,'cond3'=>$cond3,'cond4'=>$cond4,'cond5'=>$cond5,'cond6'=>$cond6,'cardno'=>$cardno]);
        return response()->json(['success'=>'the information has successfuly saved','id_ef'=>$id_ef,'id_ep'=>$id_ep,'cond1'=>$cond1,'cond2'=>$cond2,'cond3'=>$cond3,'cond4'=>$cond4,'cond5'=>$cond5,'cond6'=>$cond6,'cardno'=>$cardno]);
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
        $values = array('level' => 3,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول حراست:بازگرداندن درخواست به کارتابل خود توسط مسئول حراست");
        DB::table('workflows')->insert($values);
        //level->2
        Enteringform::where('id_ef', $id_ef)->update(['level'=>4]);
        //open page
        return response()->json(['success'=> 'hi']);
    }
    public function not_confirmed_boss()
    {
        $part = auth()->user()->id_request_part;
        $data = Enteringform::limit(5)->where('level', -2)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function unauth_duration()
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        if($date_shamsi_array[1]<10){
            $date_shamsi_array[1]='0'.$date_shamsi_array[1];
        }
        if($date_shamsi_array[2]<10){
            $date_shamsi_array[2]='0'.$date_shamsi_array[2];
        }
        $current_date_shamsi=$date_shamsi_array[0].$date_shamsi_array[1].$date_shamsi_array[2];
        $titles=Enteringtitle::all();
        $data = Enteringpeaple::limit(100)->where('date_shamsi_exit','<',$current_date_shamsi)->orderBy('id_ep','DESC')->get()->toArray();
        return response()->json(['results'=> $data,'titles'=>$titles]);
    }
    public function auth_cards()
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        if($date_shamsi_array[1]<10){
            $date_shamsi_array[1]='0'.$date_shamsi_array[1];
        }
        if($date_shamsi_array[2]<10){
            $date_shamsi_array[2]='0'.$date_shamsi_array[2];
        }
        $current_date_shamsi=$date_shamsi_array[0].$date_shamsi_array[1].$date_shamsi_array[2];
        $titles=Enteringtitle::all();
        $data = Enteringpeaple::limit(100)->where('date_shamsi_enter','<=',$current_date_shamsi)->where('date_shamsi_exit','>=',$current_date_shamsi)->where('cardno','>',0)->orderBy('id_ep','DESC')->get()->toArray();
        return response()->json(['results'=> $data,'titles'=>$titles]);
    }
    public function unauth_cards()
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        if($date_shamsi_array[1]<10){
            $date_shamsi_array[1]='0'.$date_shamsi_array[1];
        }
        if($date_shamsi_array[2]<10){
            $date_shamsi_array[2]='0'.$date_shamsi_array[2];
        }
        $current_date_shamsi=$date_shamsi_array[0].$date_shamsi_array[1].$date_shamsi_array[2];
        $titles=Enteringtitle::all();
        $data = Enteringpeaple::limit(100)->where('date_shamsi_exit','<',$current_date_shamsi)->where('cardno','>',0)->orderBy('id_ep','DESC')->get()->toArray();
        return response()->json(['results'=> $data,'titles'=>$titles]);
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($num, $persian, $string);
        return $englishNumbersOnly;
    }


}
