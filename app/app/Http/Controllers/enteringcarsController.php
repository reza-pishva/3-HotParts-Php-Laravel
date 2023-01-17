<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Enteringcar;
use App\Enteringform;
use App\Enteringpeaple;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class enteringcarsController extends Controller
{
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $enteringcar=new Enteringcar();
        $enteringcar->id_ef=$id_ef;
        $enteringcar->id_user=$id_user;
        $enteringcar->car_name=$request->input('car_name');
        $enteringcar->car_no=$request->input('car_no');
        $enteringcar->driver_name=$request->input('driver_name');
        $enteringcar->area=$request->input('area');
        $date=DB::table('enteringpeaples')->where('id_ef',$id_ef)->orderBy('date_shamsi_exit', 'DESC')->first()->date_shamsi_exit;
        $enteringcar->date_shamsi_exit=$this->convert($date);
        $enteringcar->save();
        Enteringform::where('id_ef', $id_ef)->update(['s3'=>1,'permission1'=>1]);

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

        $car=Enteringcar::where('id_ef',$id_ef)->get()->count();
        $id_ec = DB::table('enteringcars')->where('id_user',$id_user)->orderBy('id_ec', 'DESC')->first()->id_ec;
        return response()->json(['success'=>'hi','id_ec'=>$id_ec,'cars'=>$car]);
    }
    public  function store2(Request $request){
        $id_user=auth()->user()->id;
        //$id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $enteringcar=new Enteringcar();
        $enteringcar->id_ef=$request->input('id_ef');
        $id_ef=$request->input('id_ef');
        $enteringcar->id_user=$id_user;
        $enteringcar->car_name=$request->input('car_name');
        $enteringcar->car_no=$request->input('car_no');
        $enteringcar->driver_name=$request->input('driver_name');
        $enteringcar->area=$request->input('area');
        $date=DB::table('enteringpeaples')->where('id_ef',$id_ef)->orderBy('date_shamsi_exit', 'DESC')->first()->date_shamsi_exit;
        $enteringcar->date_shamsi_exit=$this->convert($date);
        $enteringcar->save();



        $car=Enteringcar::where('id_ef',$id_ef)->get()->count();
        $id_ec = DB::table('enteringcars')->where('id_user',$id_user)->orderBy('id_ec', 'DESC')->first()->id_ec;
        return response()->json(['success'=>'hi','id_ec'=>$id_ec,'cars'=>$car]);
    }
    public function delete($id){
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        Enteringcar::where('id_ec', $id)->delete();
        $car=Enteringcar::where('id_ef',$id_ef)->get()->count();
        if($car==0){
            Enteringform::where('id_ef', $id_ef)->update(['s3'=>0,'permission1'=>0,'level'=>0]);
        }
        return response()->json(['success'=>'hi','data'=>$id,'car'=>$car]);
    }
    public function delete2($id){
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        Enteringcar::where('id_ec', $id)->delete();
        $cars=Enteringcar::where('id_ef',$id_ef)->get()->count();
        if($cars==0){
            Enteringform::where('id_ef', $id_ef)->update(['s3'=>1,'permission1'=>0]);
        }
        return response()->json(['success'=>'hi','data'=>$id,'$cars'=>$cars]);
    }
    public function delete_all($id){

        Enteringcar::where('id_ef',$id)->delete();
        return response()->json(['success'=>'hi']);
    }
    public function editcar(Request $request)
    {
        $id_ec=(int)$request->input('id_ec');
        $car_name=$request->input('car_name');
        $car_no=$request->input('car_no');
        $driver_name=$request->input('driver_name');
        $area=$request->input('area');
        Enteringcar::where('id_ec', $id_ec)->update([
            'car_name'=>$car_name,
            'car_no'=>$car_no,
            'area'=>$area,
            'driver_name'=>$driver_name]);
        return response()->json(['success'=>'the information has successfuly saved','id_ec'=>$id_ec,'car_name'=>$car_name]);

    }
    public function truecars(){
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
        $data = DB::table('enteringcars')->where('date_shamsi_exit','>=',$current_date_shamsi)->orderBy('id_ec','DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function falsecars(){
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
        $data = DB::table('enteringcars')->where('date_shamsi_exit','<',$current_date_shamsi)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function selectcar($id)
    {
        $car_name = DB::table('enteringcars')->where('id_ec', $id)->get()->first()->car_name;
        $car_no = DB::table('enteringcars')->where('id_ec', $id)->get()->first()->car_no;
        $driver_name = DB::table('enteringcars')->where('id_ec', $id)->get()->first()->driver_name;
        $area = DB::table('enteringcars')->where('id_ec', $id)->get()->first()->area;
        $date_shamsi_exit = DB::table('enteringcars')->where('id_ec', $id)->get()->first()->date_shamsi_exit;
        $year=substr($date_shamsi_exit,0,4);
        $month=substr($date_shamsi_exit,4,2);
        $day=substr($date_shamsi_exit,6,2);
        $date_shamsi_exit=$year.'/'.$month.'/'.$day;
        $p1=substr($car_no,0,2);
        $p2=substr($car_no,2,2);
        $p3=substr($car_no,4,3);
        $id_ec=$id;
        return view('printcar',compact('car_name','car_no','driver_name','area','date_shamsi_exit','p1','p2','p3','id_ec'));
    }

}
