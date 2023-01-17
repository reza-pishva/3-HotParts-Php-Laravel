<?php
//مسئول مستقیم
namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Enteringform;
use App\Enteringpeaple;
use App\Form;
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

class confirm1_entering extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create_first_reciever()
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
                if($role_name['role'] ==="admin" or $role_name['role'] ==="first_level_confirmation_entering"){
                    $allow=1;
                    $g_y = Carbon::now()->year;
                    $g_m = Carbon::now()->month;
                    $g_d = Carbon::now()->day;
                    $Calendar=new CalendarHelper();
                    $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                    $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                    $mytime=Carbon::now();
                    $part = auth()->user()->id_request_part;
                    $requests=Enteringform::where('id_request_part',$part)->where('level',1)->get();
                    return view('entering_peaple.enterform_first_reciever',compact('date_shamsi','user','part','requests','mytime','full_name'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }
    public function level1()
    {
        $part = auth()->user()->id_request_part;
        $data = Enteringform::where('id_request_part', $part)->where('level',1)->orderBy('id_ef', 'DESC')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function level1_mob()
    {
        $part = auth()->user()->id_request_part;
        $data = Enteringform::where('id_request_part', $part)->where('level',1)->orderBy('id_ef', 'DESC')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function level2()
    {
        $part = auth()->user()->id_request_part;
        $data = Enteringform::where('id_request_part', $part)->where('level',2)->orderBy('id_ef', 'DESC')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function not_confirmed_boss()
    {
        $part = auth()->user()->id_request_part;
        $data = Enteringform::where('id_request_part', $part)->where('level', -1)->orderBy('id_ef', 'DESC')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function not_confirmed_boss2()
    {
        $part = auth()->user()->id_request_part;
        $data = Enteringform::where('id_request_part', $part)->where('level', -4)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function totalparts()
    {
        $part = auth()->user()->id_request_part;
        $data = Enteringform::where('id_request_part', $part)->where('id_ef','>',0)->orderBy('id_ef', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function level_1()
    {
        //$user = auth()->user()->id;
        $part = auth()->user()->id_request_part;
        $data = Enteringform::where('id_request_part', $part)->where('level',-1)->orderBy('id_ef', 'DESC')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function level_2()
    {
        //$user = auth()->user()->id;
        $part = auth()->user()->id_request_part;
        $data = Enteringform::where('id_request_part', $part)->where('level',-2)->orderBy('id_ef', 'DESC')->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'users'=>$data3]);
    }
    public function confirm1($id)
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
        $values = array('level' => 2,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول قسمت: تایید درخواست توسط مسئول مستقیم و ارسال به واحد ایمنی");
        DB::table('workflows')->insert($values);
        //level->2
        Enteringform::where('id_ef', $id_ef)->update(['level'=>2]);
        Enteringpeaple::where('id_ef', $id_ef)->update(['let_show'=>0]);
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
    public function return1($id)
    {
        $requests=Enteringform::where('id_ef',$id)->get()->first();
        return view('reasons1',compact('requests'));
    }
    public function returnform(Request $request)
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_ef=$request->input('id_ef2');
        $reason1=$request->input('reason1');
        Enteringform::where('id_ef', $id_ef)->update(['reason1'=>$reason1,'level'=>-1]);

        $id_user = auth()->user()->id;

        $values = array('level' => -1,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول قسمت:عدم تایید فرم توسط مسئول مستقیم");
        DB::table('workflows')->insert($values);
        $values = array('level' => -1,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$reason1);
        DB::table('workflows')->insert($values);

        return response()->json(['success'=>'the information has successfuly saved','result'=>$id_ef]);

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
        $values = array('level' => 1,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول قسمت:بازگرداندن درخواست به کارتابل خود توسط مسئول مستقیم");
        DB::table('workflows')->insert($values);
        //level->2
        Enteringform::where('id_ef', $id_ef)->update(['level'=>1]);
        //open page
        return response()->json(['success'=> 'hi']);
    }
    public function returned()
    {
        $part = auth()->user()->id_request_part;
        $data = Enteringform::where('id_request_part', $part)->where('level',-2)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
}
