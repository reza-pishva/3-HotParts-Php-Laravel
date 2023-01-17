<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Enteringcar;
use App\Enteringeq;
use App\Enteringform;
use App\Enteringin;
use App\Enteringpeaple;
use App\Enteringtitle;
use App\Enteringupload;
use App\Groupuser;
use App\Querytext;
use App\Requestpart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class enteringformsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function enteringfirstrequester()
    {
        $f_name=auth()->user()->f_name;
        $l_name=auth()->user()->l_name;
        $full_name=$f_name.' '.$l_name;
        $persons=Enteringtitle::all();
        return view('entering_peaple.enteringformpublic',compact('persons','full_name'));
    }
    public function firstreport()
    {
        $id_user = auth()->user()->id;
        $data = Enteringform::where('id_user', $id_user)->where('level',1)->orderBy('id_ef', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function secondreport()
    {
        $id_user = auth()->user()->id;
        $data = Enteringform::where('id_user', $id_user)->where('id_ef','>',0)->orderBy('id_ef', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function thirdreport()
    {
        $id_user = auth()->user()->id;
        $data = Enteringform::where('id_user', $id_user)->where('level',-1)->orderBy('id_ef', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function fourthreport()
    {
        $id_user = auth()->user()->id;
        $data = Enteringform::where('id_user', $id_user)->where('level','>',5)->orderBy('id_ef', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function create()
    {

//        حذف اطلاعات ناقص
        $id_user=auth()->user()->id;
        if(DB::table('enteringforms')->where('id_user',$id_user)->get()->count()>0){
            $id_ef= DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
            $s1=DB::table('enteringforms')->where('id_ef',$id_ef)->orderBy('id_ef', 'DESC')->first()->s1;
            $s2=DB::table('enteringforms')->where('id_ef',$id_ef)->orderBy('id_ef', 'DESC')->first()->s2;
            $s3=DB::table('enteringforms')->where('id_ef',$id_ef)->orderBy('id_ef', 'DESC')->first()->s3;
            $s4=DB::table('enteringforms')->where('id_ef',$id_ef)->orderBy('id_ef', 'DESC')->first()->s4;
            $s5=DB::table('enteringforms')->where('id_ef',$id_ef)->orderBy('id_ef', 'DESC')->first()->s5;
            $level=DB::table('enteringforms')->where('id_ef',$id_ef)->orderBy('id_ef', 'DESC')->first()->level;
            if($s1==0 || $s2==0 || $s3==0 || $s4==0 || $s5==0 || $level==0){
                Enteringform::where('id_ef', $id_ef)->delete();
                Enteringcar::where('id_ef', $id_ef)->delete();
                Enteringin::where('id_ef', $id_ef)->delete();
                Enteringeq::where('id_ef', $id_ef)->delete();
                Enteringupload::where('id_ef', $id_ef)->delete();
                Enteringpeaple::where('id_ef', $id_ef)->delete();
            }
        }




        $f_name=auth()->user()->f_name;
        $l_name=auth()->user()->l_name;
        $full_name=$f_name.' '.$l_name;
        $persons=Enteringtitle::all();
        return view('entering_peaple.enteringrequest1',compact('persons','full_name'));
    }
    public  function store(Request $request){
        date_default_timezone_set('Asia/Tehran');
        $id_user=auth()->user()->id;
        $part = auth()->user()->id_request_part;
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
        $date_shamsi=$date_shamsi_array[0].$date_shamsi_array[1].$date_shamsi_array[2];

        $enteringform=new Enteringform();
        $enteringform->title=$request->input('title');
        $enteringform->company=$request->input('company');
        $enteringform->id_user=auth()->user()->id;

        $enteringform->time_enter=$request->input('time_enter');
        $enteringform->date_shamsi_enter=$request->input('date_shamsi_enter');
        $date_shamsi_enter_array=explode('/',$enteringform->date_shamsi_enter);
        $enteringform->date_shamsi_enter=$date_shamsi_enter_array[0].$date_shamsi_enter_array[1].$date_shamsi_enter_array[2];
        $enteringform->time_exit=$request->input('time_exit');
        $enteringform->date_shamsi_exit=$request->input('date_shamsi_exit');
        $date_shamsi_exit_array=explode('/',$enteringform->date_shamsi_exit);
        $enteringform->date_shamsi_exit=$date_shamsi_exit_array[0].$date_shamsi_exit_array[1].$date_shamsi_exit_array[2];


        $enteringform->date_shamsi=$date_shamsi;
        $enteringform->s1=1;
        $enteringform->s2=0;
        $enteringform->s3=0;
        $enteringform->s4=0;
        $enteringform->s5=0;
        $enteringform->permission1=0;
        $enteringform->permission2=0;
        $enteringform->permission3=0;
        $enteringform->reason1='';
        $enteringform->reason2='';
        $enteringform->level=0;
        $enteringform->id_request_part=$part;

        $enteringform->save();
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_ef = DB::table('enteringforms')->where('id_user', $id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        //inserting workflow updating request_level
        $values = array('level' => 1,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"درخواست کننده: ایجاد درخواست و ارسال برای مسئول قسمت");
        DB::table('workflows')->insert($values);

        return response()->json(['success'=>'hi','data'=>$id_ef]);
    }
    public function updatepermission1(Request $request)
    {
        $id_ef=(int)$request->input('id_ef');
        $permission1=$request->input('permission1');
        Enteringform::where('id_ef', $id_ef)->update(['permission1'=>$permission1]);
        Enteringform::where('id_ef', $id_ef)->update(['s3'=>1]);

        $id_user=auth()->user()->id;
        $s1=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s1;
        $s2=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s2;
        $s3=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s3;
        $s4=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s4;
        $s5=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s5;

        if($s1==1 && $s2==1 && $s3==1 && $s4==1 && $s5==1){
            Enteringform::where('id_ef', $id_ef)->update(['level'=>1]);
        }else{
            Enteringform::where('id_ef', $id_ef)->update(['level'=>0]);
        }

        if($permission1==2){
            Enteringcar::where('id_ef', $id_ef)->delete();
        }

        return response()->json(['success'=>'the information has successfuly saved']);
    }
    public function updatepermission2(Request $request)
    {
        $id_ef=(int)$request->input('id_ef');
        $permission2=$request->input('permission2');
        Enteringform::where('id_ef', $id_ef)->update(['permission2'=>$permission2]);
        Enteringform::where('id_ef', $id_ef)->update(['s4'=>1]);

        $id_user=auth()->user()->id;
        $s1=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s1;
        $s2=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s2;
        $s3=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s3;
        $s4=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s4;
        $s5=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s5;

        if($s1==1 && $s2==1 && $s3==1 && $s4==1 && $s5==1){
            Enteringform::where('id_ef', $id_ef)->update(['level'=>1]);
        }else{
            Enteringform::where('id_ef', $id_ef)->update(['level'=>0]);
        }

        if($permission2==2){
            Enteringin::where('id_ef', $id_ef)->delete();
        }

        return response()->json(['success'=>'the information has successfuly saved']);
    }
    public function updatepermission3(Request $request)
    {
        $level=0;
        $id_ef=(int)$request->input('id_ef');

        $permission3=$request->input('permission3');
        Enteringform::where('id_ef', $id_ef)->update(['permission3'=>$permission3]);
        Enteringform::where('id_ef', $id_ef)->update(['s5'=>1]);


        $id_user=auth()->user()->id;
        $s1=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s1;
        $s2=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s2;
        $s3=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s3;
        $s4=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s4;
        $s5=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s5;

        if($s1==1 && $s2==1 && $s3==1 && $s4==1 && $s5==1){
            $level=1;
            Enteringform::where('id_ef', $id_ef)->update(['level'=>1]);
        }else{
            $level=0;
            Enteringform::where('id_ef', $id_ef)->update(['level'=>0]);
        }

        if($permission3==2){
            Enteringeq::where('id_ef', $id_ef)->delete();
            Enteringupload::where('id_ef', $id_ef)->delete();
        }


        return response()->json(['success'=>'the information has successfuly saved','level'=>$level]);
    }
    public function editform(Request $request)
    {
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user', $id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;

//        $date_shamsi_enter = DB::table('enteringforms')->where('id_ef',$id_ef)->first()->date_shamsi_enter;
//        $date_shamsi_exit = DB::table('enteringforms')->where('id_ef',$id_ef)->first()->date_shamsi_exit;
//        $time_enter = DB::table('enteringforms')->where('id_ef',$id_ef)->first()->time_enter;
//        $time_exit = DB::table('enteringforms')->where('id_ef',$id_ef)->first()->time_exit;
//
//        $string=$date_shamsi_exit;
//        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
//        $num = range(0, 9);
//        $date_no2=str_replace($persian,$num, $string);
//        $string=$date_shamsi_enter;
//        $date_no1=str_replace($persian,$num, $string);
//
//
//        $persons=DB::table('enteringpeaples')->where('id_ef',$id_ef)->get()->toArray();
//        foreach ($persons as $person) {
//            $code=$person->code_melli;
//            $id_ep=$person->id_ep;
//            $persons2= DB::table('enteringpeaples')->where('code_melli',$code)->get()->toArray();
//            foreach ($persons2 as $person2) {
//                if($person2->id_ep != $id_ep){
////                    $date_no1_pr = DB::table('enteringpeaples')->where('id_ep',$id_ep)->first()->date_no1;
//                    $date_no2_pr = DB::table('enteringpeaples')->where('id_ep',$id_ep)->first()->date_no2;
//                    if(($date_no1>$date_no2_pr) and ($date_no1<= $date_no2)){
//                        Enteringpeaple::where('id_ep', $id_ep)->update([
//                            'date_shamsi_enter' => $date_shamsi_enter,
//                            'date_shamsi_exit' => $date_shamsi_exit,
//                            'time_enter' => $time_enter,
//                            'time_exit' => $time_exit,
//                        ]);
//                        continue;
//                    }
//                    else{
//                        return response()->json(['reapeted'=>1]);
//                    }
//                }
//            }
//        }

        $title=$request->input('title');
        $company=$request->input('company');
        Enteringform::where('id_ef', $id_ef)->update(['title'=>$title,'company'=>$company]);
        return response()->json(['reapeted'=>0]);

    }
    public function editform4(Request $request)
    {
        $id_ef=(int)$request->input('id_ef');
        $title=$request->input('title');
        $company=$request->input('company');
        //dd($id_ef);
        Enteringform::where('id_ef', $id_ef)->update(['title'=>$title,'company'=>$company]);
        return response()->json(['success'=>'the information has successfuly saved','id_ef'=>$id_ef]);

    }
    public function recivefirstreport1($id)
    {
        $title = Enteringform::where('id_ef', $id)->get()->first()->title;
        $company = Enteringform::where('id_ef', $id)->get()->first()->company;
        $persons = Enteringpeaple::where('id_ef', $id)->get()->toArray();
        $titles=Enteringtitle::all();
        $cars=Enteringcar::where('id_ef', $id)->get()->toArray();
        $els=Enteringin::where('id_ef', $id)->get()->toArray();
        $eqs=Enteringeq::where('id_ef', $id)->get()->toArray();
        $equs=Enteringupload::where('id_ef', $id)->get()->toArray();
        return response()->json(['success'=>'hi','title'=> $title,'company'=> $company,'persons'=>$persons,'titles'=>$titles,'cars'=>$cars,'els'=>$els,'eqs'=>$eqs,'equs'=>$equs]);
    }
    public function delete($id){
        Enteringform::where('id_ef', $id)->delete();
        Enteringcar::where('id_ef', $id)->delete();
        Enteringin::where('id_ef', $id)->delete();
        Enteringeq::where('id_ef', $id)->delete();
        Enteringupload::where('id_ef', $id)->delete();
        Enteringpeaple::where('id_ef', $id)->delete();
        return response()->json(['success'=>'hi']);
    }
    public function send($id)
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
        $id_user=auth()->user()->id;
        $values = array('level' => 1,'id_exit' =>$id_ef+1000000,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"درخواست کننده:ارسال مجدد برای مسئول قسمت");
        DB::table('workflows')->insert($values);
        Enteringform::where('id_ef', $id_ef)->update(['level'=>1]);
        //open page
        return response()->json(['success'=> 'hi']);
    }
    public function report()
    {
        $id_user = auth()->user()->id;
        $id_gr=Groupuser::where('id_user',$id_user)->get()->toArray();
        //dd($id_gr);
        if($id_gr[0]['id_gr']==272){
            $page='/requester';
        }
        if($id_gr[0]['id_gr']==273){
            $page='/first-reciever';
        }
        if($id_gr[0]['id_gr']==274){
            $page='/second-reciever';
        }
        if($id_gr[0]['id_gr']==275){
            $page='/third-reciever';
        }
        if($id_gr[0]['id_gr']==276){
            $page='/fourth-reciever';
        }
        if($id_gr[0]['id_gr']==278){
            $page='/herasat';
        }
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        return view('report_people1',compact('page'));
    }
    public function report_queryp(Request $request)
    {
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


        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
        $date_exit_shamsi1=$request->input('date_exit_shamsi1');
        $date_shamsi_array1 = explode('/',$date_exit_shamsi1);
        $date_exit_shamsi2=$request->input('date_exit_shamsi2');
        $date_shamsi_array2 = explode('/',$date_exit_shamsi2);
        $date_exit_shamsi1=$date_shamsi_array1[0].$date_shamsi_array1[1].$date_shamsi_array1[2];
        $date_exit_shamsi2=$date_shamsi_array2[0].$date_shamsi_array2[1].$date_shamsi_array2[2];
        $date_exit_shamsi1=$this->convert($date_exit_shamsi1);
        $date_exit_shamsi2=$this->convert($date_exit_shamsi2);
        $allow=$request->input('allow');
        $code_melli=$request->input('code_melli');
        $part=$request->input('part');
        $id_requester=$request->input('id_requester');
        if($part==0){
            $query6="id_ep>0";
        }
        if($id_requester==0){
            $query7="id_ep>0";
        }
        if($code_melli==''){
            $query8="id_ep>0";
        }
        if($allow==0){
            $query9="id_ep>0";
        }

        $query1="date_no1>=".$date_exit_shamsi1;
        $query2="date_no1<=".$date_exit_shamsi2;
        if($part!=0){
            $query6="id_request_part=".$part;
        }
        if($allow==1){
            $query9="date_no2>=".$current_date_shamsi;
        }
        if($allow==2){
            $query9="date_no2<".$current_date_shamsi;
        }
        if($id_requester!=0){
            $query7="id_user=".$id_requester;
        }
        if($code_melli!=''){
            $query8="code_melli=".$code_melli;
        }
        $query10="notlet2="."0";
        Querytext::where('id_user', $id_user)->delete();
        $query="SELECT * FROM enteringpeaples WHERE ".$query1." AND ".$query2." AND ".$query7." AND ".$query8." AND ".$query6." AND ".$query9." AND ".$query10." AND ".$query10." ORDER BY id_ep DESC";
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        $forms = DB::table('enteringforms')->where('id_ef','>',0)->get()->toArray();
        return response()->json(['results'=> $requests,'forms'=>$forms]);
    }
    public function reportp()
    {
        $datas = Enteringpeaple::limit(20)->where('id_ef','>', 0)->orderBy('id_ef', 'desc')->get()->toArray();
        $parts=Requestpart::all();
        $requesters=Groupuser::where('id_gr',272)->get()->toArray();
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        return view('./entering_peaple/reportp',compact('parts','requesters','users','datas'));
    }
}
