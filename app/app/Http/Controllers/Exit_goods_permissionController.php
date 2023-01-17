<?php

namespace App\Http\Controllers;
use App\Grouprole;
use App\Groupuser;
use App\Querytext;
use App\Requestpart;
use App\Role;
use App\User;
use App\Workflow;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exit_goods_permission;
use App\Goodstype;
use App\Request_level;
use Illuminate\Http\Request;
use App\CalendarHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class Exit_goods_permissionController extends Controller
{
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function report()
    {
        $page='';
        $datas = Exit_goods_permission::limit(20)->where('id_exit','>', 0)->orderBy('id_exit', 'desc')->get()->toArray();
        $goodstypes=Goodstype::all();
        $parts=Requestpart::all();
        $requesters=Groupuser::where('id_gr',272)->get()->toArray();
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
        return view('report',compact('goodstypes','parts','requesters','users','datas','page'));
    }
    public function report_query(Request $request)
    {
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

        $enter_exit=$request->input('enter_exit');
        $with_return=$request->input('with_return');
        $id_goods_type=$request->input('id_goods_type');
        $part=$request->input('part');
        $id_requester=$request->input('id_requester');
        $level=$request->input('level');
        $jamdari_no=$request->input('jamdari_no');

        if($enter_exit==0){
            $query3="id_exit>0";
        }
        if($with_return==0){
            $query4="id_exit>0";
        }
        if($id_goods_type==0){
            $query5="id_exit>0";
        }
        if($part==0){
            $query6="id_exit>0";
        }
        if($id_requester==0){
            $query7="id_exit>0";
        }
        if($jamdari_no==''){
            $query8="id_exit>0";
        }
        if($level==0){
            $query9="id_exit>0";
        }
        $query1="date_request_shamsi2>=".$date_exit_shamsi1;
        $query2="date_request_shamsi2<=".$date_exit_shamsi2;
        if($enter_exit!=0){
            $query3="enter_exit=".$enter_exit;
        }
        if($with_return!=0){
            $query4="with_return=".$with_return;
        }
        if($id_goods_type!=0){
            $query5="id_goods_type=".$id_goods_type;
        }
        if($part!=0){
            $query6="id_request_part=".$part;
        }
        if($id_requester!=0){
            $query7="id_requester=".$id_requester;
        }
        if($jamdari_no!=''){
            $query8="jamdari_no=".$jamdari_no;
        }
        if($level==1){
            $query9="level=4 AND enter_exit=1";
        }
        if($level==2){
            $query9="level=6 OR (level=5 AND with_return=1)";
        }
        if($level==3){
            $query9="level=3";
        }
        if($level==4){
            $query9="level=2";
        }
        if($level==5){
            $query9="level=1";
        }
        if($level==6){
            $query9="level=-3";
        }
        if($level==7){
            $query9="level=-2";
        }
        if($level==8){
            $query9="level=-1";
        }
        if($level==9){
            $query9="(level=5 OR level=8)";
        }
        if($level==10){
            $query9="level=7 AND (enter_exit=2 OR with_return=1)";
        }
        Querytext::where('id_user', $id_user)->delete();
        $query="SELECT * FROM exit_goods_permissions WHERE ".$query1." AND ".$query2." AND ".$query3." AND ".$query4." AND ".$query5." AND ".$query6." AND ".$query7." AND ".$query8." AND ".$query9." ORDER BY id_exit DESC";
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'users'=>$users]);
    }
    public function report_prev()
    {
        $id_user = auth()->user()->id;
        $goodstypes=Goodstype::all()->toArray();
        $query=Querytext::where('id_user',$id_user)->orderBy('id_qu', 'desc')->first()->toArray();
        $requests = DB::select(DB::raw($query['query_text']));
        if($requests != null)
        {
            return view('print3',compact('requests','goodstypes'));
        }
        else
        {
            return view('notfound');
        }
    }
    public function notfound()
    {
        return view('notfound');
    }
    public function undercons()
    {
        return view('undercons');
    }
    public function usernotfound()
    {
        return view('usernotfound');
    }
    public function duplicateduser()
    {
        return view('duplicateduser');
    }
    public function test3()
    {
        return view('test3');
    }
    public function create2()
    {
        //--access level-----
        $user = auth()->user()->id;
        $groupusers=Groupuser::where('id_user',$user)->get()->toArray();
        $allow=0;
        foreach ($groupusers as $groupuser) {
            $grouproles=Grouprole::where('id_gr',$groupuser['id_gr'])->get()->toArray();
            foreach ($grouproles as $grouprole) {

                $role_name=Role::where('id_role',$grouprole['id_role'])->first();
                if($role_name['role'] ==="admin" or $role_name['role'] ==="request_sending"){
                    $allow=1;
                    $user = auth()->user()->id;
                    $f_name=auth()->user()->f_name;
                    $l_name=auth()->user()->l_name;
                    $full_name=$f_name.' '.$l_name;
                    $g_y = Carbon::now()->year;
                    $g_m = Carbon::now()->month;
                    $g_d = Carbon::now()->day;
                    $Calendar=new CalendarHelper();
                    $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                    //$date_shamsi_array=$Calendar->jalali_to_gregorian($g_y, $g_m, $g_d);
                    $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                    $mytime=Carbon::now();
                    $part = auth()->user()->id_request_part;
                    $goodstypes=Goodstype::all();
                    $requests=Exit_goods_permission::where('id_requester',$user)->where('level',1)->get();
                    return view('exitformpublic2',compact('goodstypes','date_shamsi','user','part','requests','mytime','full_name'));
                }

            }
        }

        if($allow===0){
            return view('access_denied');
        }
        //--access level-----


    }
    public function returned()
    {
        $user = auth()->user()->id;
        $data = Exit_goods_permission::where('id_requester', $user)
            ->Where(function ($query) {
                  $query->where('level',4)
                      ->orWhere('level',5)
                      ->orWhere('level',6)
                      ->orWhere('level',7);})->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function total_sent()
    {
        $user = auth()->user()->id;
        $data = Exit_goods_permission::limit(100)->where('id_requester', $user)->where('level','>',-3)->where('level','<',8)->orderBy('id_exit', 'desc')->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function not_confirmed()
    {
        $user = auth()->user()->id;
        $data = Exit_goods_permission::where('id_requester', $user)->where('level', 1)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public function not_confirmed_boss()
    {
        $user = auth()->user()->id;
        $data = Exit_goods_permission::where('id_requester', $user)->where('level', -1)->get()->toArray();
        $goodstypes=Goodstype::all()->toArray();
        return response()->json(['results'=> $data,'goodstypes'=>$goodstypes]);
    }
    public  function store(Request $request){


        $exitform=new Exit_goods_permission();
        $exitform->id_form=$request->input('id_form');
        $exitform->enter_exit=$request->input('enter_exit');
        $enter_exit=$request->input('enter_exit');
        $exitform->date_request_shamsi=$request->input('date_request_shamsi');
        $exitform->date_request_miladi=$request->input('date_request_miladi');
        $exitform->time_request=$request->input('time_request');
        $exitform->request_timestamp=$request->input('request_timestamp');
        $exitform->id_requester=$request->input('id_requester');
        $exitform->id_request_part=$request->input('id_request_part');
        $exitform->origin_destination=$request->input('origin_destination');
        $exitform->description=$request->input('description');
        $unit=$request->input('unit');
        $exitform->exit_no=$request->input('exit_no').' '.$unit;
        $exitform->jamdari_no=$request->input('jamdari_no');
        $exitform->id_goods_type=$request->input('id_goods_type');
        $exitform->with_return=$request->input('with_return');
        $exitform->level=1;
        $exitform->reason1='';
        $exitform->reason2='';
        $exitform->reason3='';

        $description2=$request->input('description12');
        $date_request_shamsi2=$request->input('date_request_shamsi');
        $date_request_shamsi2_array=explode('/',$date_request_shamsi2);
        if(strlen($date_request_shamsi2_array[1])==1){
            $date_request_shamsi2_array[1]='0'.$date_request_shamsi2_array[1];
        }
        if(strlen($date_request_shamsi2_array[2])==1){
            $date_request_shamsi2_array[2]='0'.$date_request_shamsi2_array[2];
        }
        $date_request_shamsi2=$date_request_shamsi2_array[0].$date_request_shamsi2_array[1].$date_request_shamsi2_array[2];
        $exitform->date_request_shamsi2=$date_request_shamsi2;

        $id_goods_type=$request->input('id_goods_type');
        $user = auth()->user()->l_name;
        $exitform->goods_type = DB::table('goodstypes')->where('id_goods_type',$id_goods_type)->orderBy('id_goods_type', 'DESC')->first()->description;
        $exitform->requester_name=$user;

        $exitform->save();
        $id_exit = DB::table('exit_goods_permissions')->orderBy('id_exit', 'DESC')->first()->id_exit;
        $id_user = auth()->user()->id;
        $values = array('level' => 1,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $request->input('date_request_shamsi'),'description' =>"درخواست کننده:ایجاد فرم درخواست");
        DB::table('workflows')->insert($values);
        if($description2==null){
            $description2="ندارد";
        }
        $values = array('level' => 1,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $request->input('date_request_shamsi'),'description' =>"توضیحات درخواست کننده:".$description2);
        DB::table('workflows')->insert($values);
        return response()->json(['success'=>'hi','data'=>$id_exit,'enter_exit'=>$enter_exit]);
    }
    public function delete($id){
        Exit_goods_permission::where('id_exit', $id)->delete();
        Workflow::where('id_exit', $id)->delete();
        return response()->json(['success'=>'hi','data'=>$id]);
    }
    public function editformm(Request $request)
    {
        $id_exit=$request->input('id_exit2');
        $description=$request->input('description2');
        $jamdari_no=$request->input('jamdari_no2');
        $with_return=$request->input('with_return2');
        $id_goods_type=$request->input('id_goods_type2');
        $origin_destination=$request->input('origin_destination2');
//        $unit=$request->input('unit2');
        $exit_no=$request->input('exit_no2');
        $goods=Goodstype::where('id_goods_type', $id_goods_type)->first();
        if($with_return==1){
            $with_return_text="بله";
        }else{
            $with_return_text="خیر";
        }
//        $description2=$request->input('description3');
//        $id_user=$request->input('id_requester');
//        $values = array('level' => 1,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $request->input('date_request_shamsi'),'description' =>"توضیحات درخواست کننده:".$description2);
//        DB::table('workflows')->insert($values);
        Exit_goods_permission::where('id_exit', $id_exit)->update(['description'=>$description,'exit_no'=>$exit_no,'jamdari_no'=>$jamdari_no,'with_return'=>$with_return,'id_goods_type'=>$id_goods_type,'origin_destination'=>$origin_destination]);
        return response()->json(['success'=>'the information has successfuly saved',
            'id_exit'=>$id_exit,
            'description'=>$description,
            'id_goods_type'=>$id_goods_type,
            'with_return_value'=>$with_return_text,
            'jamdari_no'=>$jamdari_no,
            'with_return'=>$with_return,
            'goods_type'=>$goods->description,
            'with_return_text'=>$with_return_text,
            'origin_destination'=>$origin_destination,
            'exit_no'=>$exit_no]);

    }
    public function editform(Request $request)
    {
        $id_exit=$request->input('id_exit2');
        $description=$request->input('description2');
        $jamdari_no=$request->input('jamdari_no2');
        $with_return=$request->input('with_return2');
        $id_goods_type=$request->input('id_goods_type2');
        $origin_destination=$request->input('origin_destination2');
        $unit=$request->input('unit2');
        $exit_no=$request->input('exit_no2').' '.$unit;
        $goods=Goodstype::where('id_goods_type', $id_goods_type)->first();
        if($with_return==1){
            $with_return_text="بله";
        }else{
            $with_return_text="خیر";
        }
        $description2=$request->input('description3');
        $id_user=$request->input('id_requester');
        $values = array('level' => 1,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $request->input('date_request_shamsi'),'description' =>"توضیحات درخواست کننده:".$description2);
        DB::table('workflows')->insert($values);
        Exit_goods_permission::where('id_exit', $id_exit)->update(['description'=>$description,'exit_no'=>$exit_no,'jamdari_no'=>$jamdari_no,'with_return'=>$with_return,'id_goods_type'=>$id_goods_type,'origin_destination'=>$origin_destination]);
        return response()->json(['success'=>'the information has successfuly saved',
            'id_exit'=>$id_exit,
            'description'=>$description,
            'id_goods_type'=>$id_goods_type,
            'with_return_value'=>$with_return_text,
            'jamdari_no'=>$jamdari_no,
            'with_return'=>$with_return,
            'goods_type'=>$goods->description,
            'with_return_text'=>$with_return_text,
            'origin_destination'=>$origin_destination,
            'exit_no'=>$exit_no]);

    }
    public function editform2(Request $request)
    {
        $id_exit=$request->input('id_exit');
        $id_herasat_exit=$request->input('id_herasat_exit');
        $date_exit_shamsi_r=$request->input('date_exit_shamsi_r');
        $date_exit_shamsi=$request->input('date_exit_shamsi');
        $time_exit=$request->input('time_exit');
        $exit_driver=$request->input('exit_driver');
        $car_name_exit=$request->input('car_name_exit');
        $car_no_exit=$request->input('car_no_exit');
        Exit_goods_permission::where('id_exit', $id_exit)->update([
                'id_herasat_exit'=>$id_herasat_exit,
                'date_exit_shamsi_r'=>$date_exit_shamsi_r,
                'date_exit_shamsi'=>$date_exit_shamsi,
                'exit_driver'=>$exit_driver,
                'time_exit'=>$time_exit,
                'car_name_exit'=>$car_name_exit,
                'car_no_exit'=>$car_no_exit]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }
    public function editform22(Request $request)
    {
        $id_exit=$request->input('id_exit');
        $date_exit_shamsi_r=$request->input('date_exit_shamsi_r');
        $date_exit_shamsi=$request->input('date_exit_shamsi');
        $time_exit=$request->input('time_exit');
        $exit_driver=$request->input('exit_driver');
        $car_name_exit=$request->input('car_name_exit');
        $car_no_exit=$request->input('car_no_exit');
        //$car_no_exit='66b444';
        Exit_goods_permission::where('id_exit', $id_exit)->update([
            'date_exit_shamsi_r'=>$date_exit_shamsi_r,
            'date_exit_shamsi'=>$date_exit_shamsi,
            'exit_driver'=>$exit_driver,
            'time_exit'=>$time_exit,
            'car_name_exit'=>$car_name_exit,
            'car_no_exit'=>$car_no_exit]);
        return response()->json(['success'=>'the information has successfuly saved',
            'test1'=>$date_exit_shamsi_r,
            'test2'=>$date_exit_shamsi,
            'test3'=>$exit_driver,
            'test4'=>$car_name_exit,
            'test5'=>$car_no_exit,
            'test6'=>$id_exit]);

    }
    public function editform33(Request $request)
    {
        //setting default values
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        //inserting workflow updating request_level
        $id_user = auth()->user()->id;


        $id_exit=$request->input('id_exit4');
        $date_enter_shamsi_r=$request->input('date_enter_shamsi_r4');
        $date_enter_shamsi=$request->input('date_enter_shamsi4');
        $time_enter=$request->input('time_enter4');
        $enter_driver=$request->input('enter_driver4');
        $car_name_enter=$request->input('car_name_enter4');
        $car_no_enter=$request->input('car_no_enter4');
        $iscomplete=$request->input('iscomplete4');
        $description_detail=$request->input('description_detail4');
        if($iscomplete==1){
            Exit_goods_permission::where('id_exit', $id_exit)->update([
                'date_enter_shamsi_r'=>$date_enter_shamsi_r,
                'date_enter_shamsi'=>$date_enter_shamsi,
                'enter_driver'=>$enter_driver,
                'time_enter'=>$time_enter,
                'car_name_enter'=>$car_name_enter,
                'iscomplete'=>$iscomplete,
                'car_no_enter'=>$car_no_enter]);
            $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$description_detail);
            DB::table('workflows')->insert($values);
        }
        if($iscomplete==2){
            Exit_goods_permission::where('id_exit', $id_exit)->update([
                'date_enter_shamsi_r'=>$date_enter_shamsi_r,
                'date_enter_shamsi'=>$date_enter_shamsi,
                'enter_driver'=>$enter_driver,
                'time_enter'=>$time_enter,
                'car_name_enter'=>$car_name_enter,
                'iscomplete'=>$iscomplete,
                'level'=>6,
                'car_no_enter'=>$car_no_enter]);
            $values = array('level' => 6,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$description_detail);
            DB::table('workflows')->insert($values);
        }

        return response()->json(['success'=>'the information has successfuly saved']);

    }
    public function editform3(Request $request)
    {
        //setting default values
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        //inserting workflow updating request_level
        $id_user = auth()->user()->id;

        $id_exit=$request->input('id_exit');
        $id_herasat_enter=$request->input('id_herasat_enter');
        $date_enter_shamsi_r=$request->input('date_enter_shamsi_r');
        $date_enter_shamsi=$request->input('date_enter_shamsi');
        $time_enter=$request->input('time_enter');
        $enter_driver=$request->input('enter_driver');
        $car_name_enter=$request->input('car_name_enter');
        $car_no_enter=$request->input('car_no_enter');
        $iscomplete=$request->input('iscomplete');

        $description_detail=$request->input('description_detail');
//        Exit_goods_permission::where('id_exit', $id_exit)->update([
////            'id_herasat_enter'=>$id_herasat_enter,
////            'date_enter_shamsi_r'=>$date_enter_shamsi_r,
////            'date_enter_shamsi'=>$date_enter_shamsi,
////            'enter_driver'=>$enter_driver,
////            'time_enter'=>$time_enter,
////            'car_name_enter'=>$car_name_enter,
////            'iscomplete'=>$iscomplete,
////            'car_no_enter'=>$car_no_enter]);
////        if($description_detail !=""){
////            $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$description_detail);
////            DB::table('workflows')->insert($values);
////        }
        if($iscomplete==1){
            Exit_goods_permission::where('id_exit', $id_exit)->update([
                'date_enter_shamsi_r'=>$date_enter_shamsi_r,
                'date_enter_shamsi'=>$date_enter_shamsi,
                'enter_driver'=>$enter_driver,
                'time_enter'=>$time_enter,
                'car_name_enter'=>$car_name_enter,
                'iscomplete'=>$iscomplete,
                'car_no_enter'=>$car_no_enter]);
            $values = array('level' => 7,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$description_detail);
            DB::table('workflows')->insert($values);
        }
        if($iscomplete==2){
            Exit_goods_permission::where('id_exit', $id_exit)->update([
                'date_enter_shamsi_r'=>$date_enter_shamsi_r,
                'date_enter_shamsi'=>$date_enter_shamsi,
                'enter_driver'=>$enter_driver,
                'time_enter'=>$time_enter,
                'car_name_enter'=>$car_name_enter,
                'iscomplete'=>$iscomplete,
                'level'=>6,
                'car_no_enter'=>$car_no_enter]);
            $values = array('level' => 6,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>$description_detail);
            DB::table('workflows')->insert($values);
        }

        return response()->json(['success'=>'the information has successfuly saved']);

    }
    public function firststation()
    {
        $part = auth()->user()->id_request_part;
        $requests=Exit_goods_permission::where('id_request_part',$part)->where('level',-1)->get();
        $goodstypes=Goodstype::all();
        return view('returnforsender',compact('requests','goodstypes'));
    }
    public function sendagain($id)
    {
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
        $values = array('level' => 1,'id_exit' =>$id_exit,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"مسئول قسمت:بازگرداندن درخواست به کارتابل خود توسط مسئول مستقیم");
        DB::table('workflows')->insert($values);
        //level->1
        DB::table('exit_goods_permissions')::where('id_exit',$id)->update(['level'=>1]);
        //open page
        return response()->json(['success'=> 'hi']);
    }
    public function selectrecord($id)
    {
        $data = Exit_goods_permission::where('id_exit', $id)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function returnform($id)
    {
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        Exit_goods_permission::where('id_exit', $id)->update(['level'=>1]);

        $id_user = auth()->user()->id;

        $values = array('level' => 1,'id_exit' =>$id,'id_user' => $id_user,'date_shamsi' => $date_shamsi,'description' =>"درخواست کننده:ارسال مجدد برای مسئول مستقیم");
        DB::table('workflows')->insert($values);


        return response()->json(['success'=>'the information has successfuly saved','result'=>$id]);

    }
}
