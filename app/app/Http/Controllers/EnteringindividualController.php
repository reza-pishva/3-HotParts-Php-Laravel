<?php

namespace App\Http\Controllers;
use App\Entering_personel_unique;
use App\CalendarHelper;
use App\Enteringindividual;
use App\Enteringkarkard;
use App\Enteringkarkard2;
use App\Enteringpeaple;
use App\Querytext;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnteringindividualController extends Controller
{

    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public  function store(Request $request)
    {

        date_default_timezone_set('Asia/Tehran');
        $Calendar=new CalendarHelper();
        $m1=Carbon::now()->hour;
        $m2=Carbon::now()->minute;
        $m6=Carbon::now()->second;
        $m3=Carbon::now()->day;
        $m4=Carbon::now()->month;
        $m5=Carbon::now()->year;
        $d1=mktime($m1, $m2,$m6, $m4, $m3, $m5);

        $enteringpeaple=new Enteringindividual();
        $enteringpeaple->DATE_TIMESTAMP=$d1;
        $enteringpeaple->id_user=auth()->user()->id;
        $enteringpeaple->f_name=$request->input('f_name');
        $enteringpeaple->l_name=$request->input('l_name');
        $enteringpeaple->code_melli=$request->input('code_melli');
        $enteringpeaple->time_enter=$request->input('time_enter');
        $enteringpeaple->enter_exit=$request->input('enter_exit');
        $presence=$request->input('enter_exit');
        $date_shamsi_enter_array=explode('/',$request->input('date_enter'));
        $enteringpeaple->date_enter=$this->convert($date_shamsi_enter_array[0].$date_shamsi_enter_array[1].$date_shamsi_enter_array[2]);
        $enteringpeaple->save();

        $i_ed = Enteringindividual::where('code_melli', $request->input('code_melli'))->orderBy('i_ed', 'DESC')->get()->first()->i_ed;
        Enteringpeaple::where('code_melli', $request->input('code_melli'))->update(['presence'=>$presence]);
        return response()->json(['success'=>'hi','i_ed2'=>$i_ed,'time_enter'=>$request->input('time_enter'),'date_enter'=>$request->input('date_enter'),'enter_exit'=>$request->input('enter_exit')]);
    }
    public  function store2(Request $request)
    {
        $enteringpeaple=new Enteringindividual();
        $date_shamsi_enter_array=explode('/',$request->input('date_enter'));
        $enteringpeaple->date_enter=$this->convert($date_shamsi_enter_array[0].$date_shamsi_enter_array[1].$date_shamsi_enter_array[2]);
        $date_shamsi=$this->convert($date_shamsi_enter_array[0].'/'.$date_shamsi_enter_array[1].'/'.$date_shamsi_enter_array[2]);
        $date_shamsi2=$this->convert($date_shamsi_enter_array[0].$date_shamsi_enter_array[1].$date_shamsi_enter_array[2]);
        $year=$this->convert($date_shamsi_enter_array[0]);
        $month=$this->convert($date_shamsi_enter_array[1]);
        $day=$this->convert($date_shamsi_enter_array[2]);
        $time=explode(':',$request->input('time_enter'));
        // $hour=substr($request->input('time_enter'),0,2);
        // $minute=substr($request->input('time_enter'),3,2);
        // $pm_am=substr($request->input('time_enter'),5,2);
        // if($pm_am=='pm'){
        //     $hour=$hour+12;
        // }
        $date = \Morilog\Jalali\CalendarUtils::toGregorian($year,$month,$day);
        $DATE_TIMESTAMP2=mktime((int)$time[0],(int)$time[1],0,(int)$date[1],(int)$date[2],(int)$date[0]);   
        //dd($DATE_TIMESTAMP2,$hour,$minute,$date[1],$date[2],$date[0]);
        $id=$request->input('code_melli');
        $enteringpeaple->DATE_TIMESTAMP=$DATE_TIMESTAMP2;
        $enteringpeaple->id_user=auth()->user()->id;
        $enteringpeaple->f_name=$request->input('f_name');
        $enteringpeaple->l_name=$request->input('l_name');
        $enteringpeaple->code_melli=$request->input('code_melli');
        $enteringpeaple->time_enter=$request->input('time_enter');
        $time_enter=$request->input('time_enter');
        $enteringpeaple->enter_exit=$request->input('enter_exit');
        $enter_exit=$request->input('enter_exit');
        $presence=$request->input('enter_exit');
        if(Enteringindividual::where('code_melli', $request->input('code_melli'))->exists()){
            $last_enter_exit = Enteringindividual::where('code_melli', $request->input('code_melli'))->orderBy('i_ed', 'DESC')->get()->first()->enter_exit;
        }else{
            $last_enter_exit =0;
        }
        
        if($last_enter_exit == $enter_exit){
            
            return response()->json(['i_ed'=>'hi']);
        }else{
            $enteringpeaple->save();
            $i_ed = Enteringindividual::where('code_melli', $request->input('code_melli'))->orderBy('i_ed', 'DESC')->get()->first()->i_ed;
            if($enter_exit==1){
                return response()->json(['i_ed'=>$i_ed,'date_enter'=>$date_shamsi,'time_enter'=>$time_enter,'enter_exit'=>1]);                           
            }    
            if($enter_exit==2){
                $i_ed1 = Enteringindividual::where('code_melli', $id)->where('enter_exit',1)->orderBy('i_ed', 'DESC')->get()->first()->i_ed;
                $i_ed2 = Enteringindividual::where('code_melli', $id)->orderBy('i_ed', 'DESC')->get()->first()->i_ed;
                $DATE_TIMESTAMP1 = Enteringindividual::where('code_melli', $id)->where('enter_exit',1)->orderBy('i_ed', 'DESC')->get()->first()->DATE_TIMESTAMP;
                Enteringpeaple::where('code_melli', $id)->update(['presence'=>$presence]);
                $karkard=($DATE_TIMESTAMP2-$DATE_TIMESTAMP1);
                $value=['code_melli'=>$id,'i_ed2'=>$i_ed2,'i_ed1'=>$i_ed1,'date_shamsi'=>$date_shamsi2,'karkard'=>$karkard];                
                DB::table('enteringkarkards')->insert($value);        
                return response()->json(['i_ed'=>$i_ed,'date_enter'=>$date_shamsi,'time_enter'=>$time_enter,'enter_exit'=>2]);   
            }    
            
        }       
    }
    public function personinfo3($id,$date1,$date2)
    {
        $id_user = auth()->user()->id;

        $string=$date1;
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $date_no1=str_replace($persian,$num, $string);
        $string=$date2;
        $date_no2=str_replace($persian,$num, $string);
//        Querytext::where('id_user', $id_user)->delete();
        $query=$id;
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $data = Enteringindividual::where('code_melli','=',$id)->where('date_enter','>=',$date_no1)->where('date_enter','<=',$date_no2)->orderBy('i_ed', 'DESC')->get()->toArray();
        return response()->json(['individuals'=> $data,'date1'=>$date1,'date2'=>$date2]);
    }
    public function personinfo4($id)
    {
//        ->orderBy('id_ed', 'DESC')->
//        $data = Enteringindividual::where('code_melli','=',$id)->orderBy('i_ed', 'DESC')->limit(2)->get()->toArray();
        $data = Enteringindividual::where('code_melli','=',$id)->orderBy('date_enter', 'DESC')->get()->toArray();
        return response()->json(['individuals'=> $data]);
    }
    public function deleteindividuals($id){
        
        $i_ed1=0;
        $i_ed2=0;
        $enter_exit = Enteringindividual::where('i_ed', $id)->orderBy('i_ed', 'DESC')->get()->first()->enter_exit;

        if(DB::table('enteringkarkards')->where('i_ed1', $id)->get()->count()>0){
            $i_ed2 = DB::table('enteringkarkards')->where('i_ed1', $id)->orderBy('id_ek', 'DESC')->get()->first()->i_ed2;
            Enteringindividual::where('i_ed', $id)->delete();
            Enteringindividual::where('i_ed', $i_ed2)->delete();
        }
        if(DB::table('enteringkarkards')->where('i_ed2', $id)->get()->count()>0){
            $i_ed1 = DB::table('enteringkarkards')->where('i_ed2', $id)->orderBy('id_ek', 'DESC')->get()->first()->i_ed1;
            Enteringindividual::where('i_ed', $id)->delete();
            Enteringindividual::where('i_ed', $i_ed1)->delete();
        }
        if(DB::table('enteringkarkards')->where('i_ed1', $id)->get()->count()==0 &&
           DB::table('enteringkarkards')->where('i_ed2', $id)->get()->count()==0){
            Enteringindividual::where('i_ed', $id)->delete();
        }
     
        
        if($enter_exit==1){
            Enteringkarkard::where('i_ed1', $id)->delete();
        }else{
            Enteringkarkard::where('i_ed2', $id)->delete();
        }
        return response()->json(['success'=>'hi','id'=>$id,'i_ed2'=>$i_ed2,'i_ed1'=>$i_ed1]);
        
    }
    public function selectindividuals($id)
    {
        $f_name = Enteringindividual::where('i_ed', $id)->get()->first()->f_name;
        $l_name = Enteringindividual::where('i_ed', $id)->get()->first()->l_name;
        $code_melli = Enteringindividual::where('i_ed', $id)->get()->first()->code_melli;
        $date_enter = Enteringindividual::where('i_ed', $id)->get()->first()->date_enter;
        $time_enter = Enteringindividual::where('i_ed', $id)->get()->first()->time_enter;
        $enter_exit = Enteringindividual::where('i_ed', $id)->get()->first()->enter_exit;
        return response()->json(['success'=>'hi','f_name'=> $f_name,'l_name'=> $l_name,'code_melli'=>$code_melli,'date_enter'=>$date_enter,'time_enter'=>$time_enter,'enter_exit'=>$enter_exit]);
    }
    public function selectindividuals2($date1,$date2)
    {
        $personels= Enteringpeaple::where('id_ep','>',0)->get()->toArray();
        foreach($personels as $personel){
            $n=Entering_personel_unique::where('code_melli',$personel['code_melli'])->get()->count();
            if($n == 0){
                DB::table('entering_personel_uniques')->insert([
                    'f_name' => $personel['f_name'],
                    'l_name' => $personel['l_name'],
                    'code_melli' => $personel['code_melli']
                ]);
            }else{
                continue;
            }
        }
        Enteringkarkard2::where('id_ek','>',0)->delete();
        $karkards = DB::table('enteringkarkards')->where('date_shamsi','>=',$date1)->where('date_shamsi','<=',$date2)->get()->toArray();
        foreach($karkards as $karkard){
           DB::table('enteringkarkard2s')->insert((array)$karkard);
        }
        // $individuals = DB::table('entering_view4')->where('karkard','>',0)->get()->toArray();
        // return response()->json(['success'=>'hi','results'=> $individuals]);
        $datas = DB::table('entering_view4')->where('karkard','>',0)->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $datas]);        
    }
    public function total_individuals($date1,$date2)
    {
        $users = User::where('id','>',0)->orderBy('id', 'DESC')->get()->toArray();
        $peaples = Enteringpeaple::where('id_ep','>',0)->orderBy('id_ep', 'DESC')->get()->toArray();
        $individuals = Enteringindividual::where('i_ed','>',0)->where('date_enter','>=',$date1)->where('date_enter','<=',$date2)->orderBy('date_enter', 'DESC')->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals,'peaples'=>$peaples,'users'=>$users,'x'=>$date1,'y'=>$date2]);
    }
    public function set_entering($id,$date,$time)
    {

        date_default_timezone_set('Asia/Tehran');
        $Calendar=new CalendarHelper();
        $m1=Carbon::now()->hour;
        $m2=Carbon::now()->minute;
        $m6=Carbon::now()->second;
        $m3=Carbon::now()->day;
        $m4=Carbon::now()->month;
        $m5=Carbon::now()->year;
        $d1=mktime($m1, $m2,$m6, $m4, $m3, $m5);


        $enteringpeaple=new Enteringindividual();
        $enteringpeaple->DATE_TIMESTAMP=$d1;
        $enteringpeaple->id_user=auth()->user()->id;
        $enteringpeaple->code_melli=$id;
        $enteringpeaple->time_enter=$time;
        $enteringpeaple->enter_exit=1;
        $presence=1;
        $enteringpeaple->date_enter=$date;
        if(Enteringindividual::where('code_melli', $id)->count() > 0){
            $enter_exit = Enteringindividual::where('code_melli', $id)->orderBy('i_ed', 'DESC')->get()->first()->enter_exit;
        }
        if(Enteringindividual::where('code_melli', $id)->count() == 0){
            $enter_exit = 20000;
        }
        if($enter_exit != 1){
            $enteringpeaple->save();
            $i_ed = Enteringindividual::where('code_melli', $id)->orderBy('i_ed', 'DESC')->get()->first()->i_ed;
            
            Enteringpeaple::where('code_melli', $id)->update(['presence'=>$presence]);
            return response()->json(['success'=>'hi','i_ed'=>$i_ed,'time_enter'=>$time,'date_enter'=>$date,'enter_exit'=>1,'code_melli'=>$id]);
        }
        
        return response()->json(['success'=>'hi','enter_exit'=>2]);
    }
    public function set_entering2($id,$date,$time)
    {
        Enteringpeaple::where('code_melli', $id)->update(['presence'=>1]);
        return response()->json(['success'=>'hi']);
    }
    public function set_exiting($id,$date,$time)
    {
        date_default_timezone_set('Asia/Tehran');
        $Calendar=new CalendarHelper();
        $m1=Carbon::now()->hour;
        $m2=Carbon::now()->minute;
        $m6=Carbon::now()->second;
        $m3=Carbon::now()->day;
        $m4=Carbon::now()->month;
        $m5=Carbon::now()->year;
        $d1=mktime($m1, $m2,$m6, $m4, $m3, $m5);

        $enteringpeaple=new Enteringindividual();
        $enteringpeaple->DATE_TIMESTAMP=$d1;
        $enteringpeaple->id_user=auth()->user()->id;
        $enteringpeaple->code_melli=$id;
        $enteringpeaple->time_enter=$time;
        $enteringpeaple->enter_exit=2;
        $presence=2;
        $enteringpeaple->date_enter=$date;
        if(Enteringindividual::where('code_melli', $id)->count() > 0){
            $enter_exit = Enteringindividual::where('code_melli', $id)->orderBy('i_ed', 'DESC')->get()->first()->enter_exit;
        }
        if(Enteringindividual::where('code_melli', $id)->count() == 0){
            $enter_exit = 20000;
        }
        if($enter_exit != 2){
            
            $enteringpeaple->save();

            $i_ed = Enteringindividual::where('code_melli', $id)->where('enter_exit', 2)->orderBy('i_ed', 'DESC')->get()->first()->i_ed;
            $last_timestamp = Enteringindividual::where('code_melli', $id)->where('enter_exit', 1)->orderBy('i_ed', 'DESC')->get()->first()->DATE_TIMESTAMP;
            if($last_timestamp != 'undefind'){
                Enteringindividual::where('i_ed', $i_ed)->update(['DIFFERENCE'=>$d1-$last_timestamp]);
            }
            

            $i_ed1 = Enteringindividual::where('code_melli', $id)->where('enter_exit',1)->orderBy('i_ed', 'DESC')->get()->first()->i_ed;
            $i_ed2 = Enteringindividual::where('code_melli', $id)->orderBy('i_ed', 'DESC')->get()->first()->i_ed;

            


            Enteringpeaple::where('code_melli', $id)->update(['presence'=>$presence]);

                $DATE_TIMESTAMP1 = Enteringindividual::where('code_melli',$id)->where('enter_exit',1)->
                orderBy('i_ed', 'DESC')->get()->first()->DATE_TIMESTAMP;
                $karkard=$d1-$DATE_TIMESTAMP1;

                
                $value=['code_melli'=>$id,'i_ed2'=>$i_ed2,'i_ed1'=>$i_ed1,'date_shamsi'=>$date,'karkard'=>$karkard];

                
                DB::table('enteringkarkards')->insert($value);

            return response()->json(['success'=>'hi','i_ed'=>$i_ed2,'time_enter'=>$time,'date_enter'=>$date,'enter_exit'=>2,'diff'=>$value]);
        }
        return response()->json(['success'=>'hi','enter_exit'=>1]);
    }
    public function set_exiting2($id,$date,$time)
    {
        Enteringpeaple::where('code_melli', $id)->update(['presence'=>2]);
        return response()->json(['success'=>'hi']);
    }
    public function updateindividuals(Request $request)
    {
        date_default_timezone_set('Asia/Tehran');
        $Calendar=new CalendarHelper();

        $id_ed=(int)$request->input('i_ed');
        $date=$request->input('date_enter');
        
        $date_shamsi_exit_array=explode('/',$request->input('date_enter'));
        $date_enter=$this->convert($date_shamsi_exit_array[0].$date_shamsi_exit_array[1].$date_shamsi_exit_array[2]);

        $date_shamsi_exit_array=$Calendar->jalali_to_gregorian($date_shamsi_exit_array[0], $date_shamsi_exit_array[1], $date_shamsi_exit_array[2]);
        
        $time_enter=$request->input('time_enter');
        $time_stamp=explode(':',$request->input('time_enter'));

        $am_pm=substr($time_stamp[1],2,1);
        if($am_pm =='p'){
            $hour=$time_stamp[0]+12;
        }else{
            $hour=$time_stamp[0];
        }
        $minute=substr($time_stamp[1],0,2);
        $year=$date_shamsi_exit_array[0];
        $month=$date_shamsi_exit_array[1];
        $day=$date_shamsi_exit_array[2];
        $d1=mktime($hour,$minute, 0,$month,$day,$year);
        
        $enter_exit=$request->input('enter_exit');
        Enteringindividual::where('i_ed', $id_ed)->update(['date_enter'=>$date_enter,'time_enter'=>$time_enter,'enter_exit'=>$enter_exit,'DATE_TIMESTAMP'=>$d1]);

        
        $id = Enteringindividual::where('i_ed',  $id_ed)->get()->first()->code_melli;
        $i_ed = Enteringindividual::where('code_melli', $id)->where('enter_exit', 2)->orderBy('i_ed', 'DESC')->get()->first()->i_ed;
        $last_timestamp = Enteringindividual::where('code_melli', $id)->where('enter_exit', 1)->where('i_ed','<',$i_ed)->orderBy('i_ed', 'DESC')->get()->first()->DATE_TIMESTAMP;
        if($enter_exit == 2){
            Enteringindividual::where('i_ed', $i_ed)->update(['DIFFERENCE'=>$d1-$last_timestamp]);
        }


        return response()->json(['success'=>'the information has successfuly saved','id_ed'=>$id_ed,'time'=>$d1,'date'=>$date]);
    }
    public function selectindp()
    {
        $datas = Enteringindividual::where('print', 1)->orderBy('i_ed', 'ASC')->get()->toArray();
        $code = Enteringindividual::where('print', 1)->get()->first()->code_melli;
        $f_name = Enteringpeaple::where('code_melli', $code)->get()->first()->f_name;
        $l_name = Enteringpeaple::where('code_melli', $code)->get()->first()->l_name;

        return view('./entering_peaple/printindividuals',compact('datas','code','f_name','l_name'));
    }
    public function reporti()
    {
        return view('./entering_peaple/reporti');
    }
    public function reporti2()
    {
        return view('./entering_peaple/reporti2');
    }
    public function report_queryi(Request $request)
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
        $code_melli=$request->input('code_melli');
        if($code_melli==''){
            $query8="i_ed>0";
        }
        $query1="date_enter>=".$date_exit_shamsi1;
        $query2="date_enter<=".$date_exit_shamsi2;
        if($code_melli!=''){
            $query8="code_melli=".$code_melli;
        }
        Querytext::where('id_user', $id_user)->delete();
        $query3="update enteringindividuals set print=0 WHERE i_ed>0";
        $requests3 = DB::update(DB::raw($query3));

        $query="SELECT * FROM enteringindividuals WHERE ".$query1." AND ".$query2." AND ".$query8." ORDER BY i_ed ASC";
        $query2="update enteringindividuals set print=1 WHERE ".$query1." AND ".$query2." AND ".$query8;
        $query3="update enteringindividuals set print=0 WHERE ".$query1." AND ".$query2." AND ".$query8;


        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        $requests2 = DB::update(DB::raw($query2));
        $forms = DB::table('enteringforms')->where('id_ef','>',0)->get()->toArray();
        return response()->json(['results'=> $requests,'forms'=>$forms]);
    }
    public function vue_total_individuals()
    {
        $individuals = DB::table('entering_view1')->where('i_ed','<',1000)->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }
    public function vue_individuals_with_permission($date1,$date2)
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


        $individuals = DB::table('entering_view2')->where('date_shamsi_enter','>=',$date1)->where('date_shamsi_enter','<=',$date2)->where('level',6)->where('date_shamsi_exit','>=',$current_date_shamsi)->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }
    public function vue_individuals_without_permission($date1,$date2)
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

        $individuals = DB::table('entering_view2')->where('date_shamsi_enter','>=',$date1)->where('date_shamsi_enter','<=',$date2)->where('level','<=',6)->where('date_shamsi_exit','>',$current_date_shamsi)->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }

    public function vue_individuals_karkard($date1,$date2,$id)
    {
        $personels= Enteringpeaple::where('id_ep','>',0)->get()->toArray();
                foreach($personels as $personel){
                    $n=Entering_personel_unique::where('code_melli',$personel['code_melli'])->get()->count();
                    if($n == 0){
                        DB::table('entering_personel_uniques')->insert([
                            'f_name' => $personel['f_name'],
                            'l_name' => $personel['l_name'],
                            'code_melli' => $personel['code_melli']
                        ]);
                    }else{
                        continue;
                    }
                }

        Enteringkarkard2::where('id_ek','>',0)->delete();
        $karkards = DB::table('enteringkarkards')->where('date_shamsi','>=',$date1)->where('date_shamsi','<=',$date2)->get()->toArray();
        foreach($karkards as $karkard){
           DB::table('enteringkarkard2s')->insert((array)$karkard);
        }
        if($id != "کد ملی فرد مورد نظر"){
            $individuals = DB::table('entering_view4')->where('karkard','>',0)->where('code_melli','=',$id)->get()->toArray();
        }else{
            $individuals = DB::table('entering_view4')->where('karkard','>',0)->get()->toArray();
        }
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }

    public function vue_individuals_karkard2($date1,$date2)
    {
        
        $date1=$this->convert($date1);
        $date2=$this->convert($date2);
        
        $personels= Enteringpeaple::where('id_ep','>',0)->get()->toArray();
                foreach($personels as $personel){
                    $n=Entering_personel_unique::where('code_melli',$personel['code_melli'])->get()->count();
                    if($n == 0){
                        DB::table('entering_personel_uniques')->insert([
                            'f_name' => $personel['f_name'],
                            'l_name' => $personel['l_name'],
                            'code_melli' => $personel['code_melli']
                        ]);
                    }else{
                        continue;
                    }
                }

        Enteringkarkard2::where('id_ek','>',0)->delete();
        $karkards = DB::table('enteringkarkards')->where('date_shamsi','>=',$date1)->where('date_shamsi','<=',$date2)->get()->toArray();
        foreach($karkards as $karkard){
           DB::table('enteringkarkard2s')->insert((array)$karkard);
        }
        $individuals = DB::table('entering_view4')->where('karkard','>',57000)->where('karkard','<',1000000)->orderBy('karkard', 'DESC')->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }


    public function vue_individuals_presence()
    {
        $individuals = DB::table('entering_view6')->where('presence',1)->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }
    public function vue_individuals_enterexit($date1,$date2,$id)
    {
        Entering_personel_unique::where('id_epu','>',0)->delete();
        $personels= Enteringpeaple::where('id_ep','>',0)->get()->toArray();
                foreach($personels as $personel){
                    $n=Entering_personel_unique::where('code_melli',$personel['code_melli'])->get()->count();
                    if($n == 0){
                        DB::table('entering_personel_uniques')->insert([
                            'f_name' => $personel['f_name'],
                            'l_name' => $personel['l_name'],
                            'code_melli' => $personel['code_melli']
                        ]);
                    }else{
                        continue;
                    }
                }
        if($id != "کد ملی فرد مورد نظر"){
            $individuals = DB::table('entering_view5')->where('date_enter','>=',$date1)->where('date_enter','<=',$date2)->where('code_melli','=',$id)->orderBy('i_ed', 'ASC')->get()->toArray();
        }else{
            $individuals = DB::table('entering_view5')->where('date_enter','>=',$date1)->where('date_enter','<=',$date2)->orderBy('i_ed', 'ASC')->get()->toArray();
        }        
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }
    public function vue_waiting_for_exit($date1,$date2)
    {
        $individuals = DB::table('exit_goods_permissions')->where('date_request_shamsi2','>=',$date1)->where('date_request_shamsi2','<=',$date2)->whereIn('level', [4, 7])->where('enter_exit','=',2)->where('iscomplete','=',1)->orderBy('id_exit', 'ASC')->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }
    public function vue_waiting_for_enter($date1,$date2)
    {
        $individuals = DB::table('exit_goods_permissions')->where('date_request_shamsi2','>=',$date1)->where('date_request_shamsi2','<=',$date2)->whereIn('level', [5, 6])->orderBy('id_exit', 'ASC')->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }
    public function vue_in_process($date1,$date2)
    {
        $individuals = DB::table('exit_goods_permissions')->where('date_request_shamsi2','>=',$date1)->where('date_request_shamsi2','<=',$date2)->where('level','<',4)->where('level','>',0)->orderBy('id_exit', 'ASC')->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }
    public function vue_not_accepted($date1,$date2)
    {
        $individuals = DB::table('exit_goods_permissions')->where('date_request_shamsi2','>=',$date1)->where('date_request_shamsi2','<=',$date2)->where('level','<',0)->orderBy('id_exit', 'ASC')->get()->toArray();
        return response()->json(['success'=>'hi','results'=> $individuals]);
    }

}
