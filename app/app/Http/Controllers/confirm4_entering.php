<?php
//حراست
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

class confirm4_entering extends Controller
{
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
                if($role_name['role'] ==="admin" or $role_name['role'] ==="gaurd_level_confirmation_entering"){
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
                    return view('entering_peaple.enterform_fourth_reciever',compact('date_shamsi','user','part','requests','mytime','full_name'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }
    public function create_fourth_reciever2()
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
                if($role_name['role'] ==="admin" or $role_name['role'] ==="gaurd_level_confirmation_entering"){
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
                    return view('entering_peaple.enteringform_fourth_reciever2',compact('date_shamsi','user','part','requests','mytime','full_name'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }
    public function persons2($code)
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
        //$hasrows=Enteringpeaple::where('code_melli',$code)->count();
        $hasrows =Enteringpeaple::where('code_melli','=',$code)->count();
        if($hasrows==1){
            $hasrows=1;
        } else{
            $hasrows=0;
        }

        $persons2 =DB::table('enteringpeaples')->where('code_melli',$code)->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->get()->toArray();

            foreach ($persons2 as $person){
                    $let_show = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->orderBy('id_ep', 'DESC')->first()->let_show;
                    $notlet2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->orderBy('id_ep', 'DESC')->first()->notlet2;
                    $date1 = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->orderBy('id_ep', 'DESC')->first()->date_shamsi_enter;
                    $date2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->orderBy('id_ep', 'DESC')->first()->date_shamsi_exit;
                    $id_ep2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->orderBy('id_ep', 'DESC')->first()->id_ep;
                    $id_ep = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->orderBy('id_ep', 'DESC')->first()->id_ep;
                    $id_ef = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->orderBy('id_ep', 'DESC')->first()->id_ef;
                    $cardno = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->orderBy('id_ep', 'DESC')->first()->cardno;
                    $title2 = DB::table('enteringforms')->where('id_ef','=',$id_ef)->orderBy('id_ef', 'DESC')->first()->title;
                    $company = DB::table('enteringforms')->where('id_ef','=',$id_ef)->orderBy('id_ef', 'DESC')->first()->company;
                    $persons = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('id_ef','=',$id_ef)->where('let_show','=',1)->get()->toArray();
                    $hefazat = DB::table('enteringhefazats')->where('id_ep', $id_ep)->orderBy('id_ep', 'DESC')->get()->toArray();

//                    $persons =DB::table('enteringpeaples')->where('code_melli',$code)->get()->toArray();
                    return response()->json(['results'=> $persons,'titles'=> $titles,'job'=> $title2,'company'=>$company,'cardno'=>$cardno,
                        'hefazat'=>$hefazat,'date1'=>$date1,'date2'=>$date2,'date'=>$current_date_shamsi,
                        'count_record'=>$code,'let_show'=>$let_show,'id_ef'=>$id_ef,'id_ep'=>$id_ep2,
                        'notlet2'=>$notlet2,'x1'=>$person->date_no1,'x3'=>$current_date_shamsi,'x2'=>$person->date_no2]);

            }








    }
//    public function persons2($code)
//    {
//        date_default_timezone_set('Asia/Tehran');
//        $g_y = Carbon::now()->year;
//        $g_m = Carbon::now()->month;
//        $g_d = Carbon::now()->day;
//        $Calendar=new CalendarHelper();
//        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
//        if($date_shamsi_array[1]<10){
//            $date_shamsi_array[1]='0'.$date_shamsi_array[1];
//        }
//        if($date_shamsi_array[2]<10){
//            $date_shamsi_array[2]='0'.$date_shamsi_array[2];
//        }
//        $current_date_shamsi=$date_shamsi_array[0].$date_shamsi_array[1].$date_shamsi_array[2];
//        $titles=Enteringtitle::all();
//        //$hasrows=Enteringpeaple::where('code_melli',$code)->count();
//        $hasrows =Enteringpeaple::where('code_melli','=',$code)->count();
//        if($hasrows==1){
//            $hasrows=1;
//        } else{
//            $hasrows=0;
//        }
//
//        $let_show = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->let_show;
//        $notlet2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->notlet2;
//        $date1 = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ep', 'DESC')->first()->date_shamsi_enter;
//        $date2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ep', 'DESC')->first()->date_shamsi_exit;
//        $id_ep2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ep', 'ASC')->first()->id_ep;
//        $id_ep = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ep', 'DESC')->first()->id_ep;
//        $id_ef = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ep', 'DESC')->first()->id_ef;
//        $cardno = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ep', 'DESC')->first()->cardno;
//        $title2 = DB::table('enteringforms')->where('id_ef','=',$id_ef)->orderBy('id_ef', 'DESC')->first()->title;
//        $company = DB::table('enteringforms')->where('id_ef','=',$id_ef)->orderBy('id_ef', 'DESC')->first()->company;
//        $persons = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('let_show','=',1)->orderBy('id_ep', 'DESC')->get()->toArray();
//        // $hefazat = Enteringhefazat::where('id_ep', $id_ep)->orderBy('id_ep', 'DESC')->get()->toArray();
//        $hefazat = DB::table('enteringhefazats')->where('id_ep', $id_ep)->orderBy('id_ep', 'DESC')->get()->toArray();
//        return response()->json(['results'=> $persons,'titles'=> $titles,'job'=> $title2,'company'=>$company,'cardno'=>$cardno,'hefazat'=>$hefazat,'date1'=>$date1,'date2'=>$date2,'date'=>$current_date_shamsi,'count_record'=>$code,'let_show'=>$let_show,'id_ef'=>$id_ef,'id_ep'=>$id_ep2,'notlet2'=>$notlet2]);//,'title'=>$title,'company'=>$company
//    }
    public function auth_duration()
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
        $data =  DB::table('enteringpeaples')->where('date_shamsi_enter','<=',$current_date_shamsi)->where('date_shamsi_exit','>=',$current_date_shamsi)->where('let_show',1)->orderBy('id_ep','DESC')->get()->toArray();

        return response()->json(['results'=>$data,'titles'=>$titles]);

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
        $data = DB::table('enteringpeaples')->where('date_shamsi_exit','<',$current_date_shamsi)->where('let_show',1)->orderBy('id_ep', 'DESC')->get()->toArray();
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
        $data = DB::table('enteringpeaples')->where('date_shamsi_enter','<=',$current_date_shamsi)->where('date_shamsi_exit','>=',$current_date_shamsi)->where('cardno','>',0)->where('let_show',1)->get()->toArray();
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
        $data = DB::table('enteringpeaples')->where('date_shamsi_exit','<',$current_date_shamsi)->where('cardno','>',0)->where('let_show',1)->get()->toArray();
        return response()->json(['results'=> $data,'titles'=>$titles]);
    }
    public function withoutcard()
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
        $data = DB::table('enteringpeaples')->where('date_shamsi_exit','>',$current_date_shamsi)->where('let_show','=',1)->where('cardno','=',0)->get()->toArray();
        return response()->json(['results'=> $data,'titles'=>$titles]);
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function presence()
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
        $count_persons =DB::table('enteringpeaples')->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->where('presence','=',1)->get()->count();
        $persons =DB::table('enteringpeaples')->where('date_no1','<=',$current_date_shamsi)->where('date_no2','>=',$current_date_shamsi)->where('presence','=',1)->get()->toArray();
        $titles=Enteringtitle::all();
        return response()->json(['results'=> $persons,'titles'=>$titles,'count_persons'=>$count_persons]);
    }
}
