<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Car;
use App\Exit_goods_permission;
use App\Goodstype;
use App\Grouprole;
use App\Groupuser;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function test()
    {
        return view('layouts.app_test');
    }
    public function herasat()
    {
        $id_user = auth()->user()->id;
        $groups=DB::table('groupusers')->where('id_user', $id_user)->get()->toArray();
        return view('main_guard',compact('groups'));
    }
    public function datetest()
    {
        date_default_timezone_set('Asia/Tehran');
        $Calendar=new CalendarHelper();
        $d1=mktime(01, 00, 0, 02, 05, 2014);
        $d2=mktime(12, 14, 55, 9, 12, 2014);
        $m1=Carbon::now()->hour;
        $m2=Carbon::now()->minute;
        $m6=Carbon::now()->second;
        $m3=Carbon::now()->day;
        $m4=Carbon::now()->month;
        $m5=Carbon::now()->year;
        //$d1=mktime($m1, $m2,$m6, $m4, $m3, $m5);
        dd($d1);
        //dd(date("Y-m-d h:i:sa", $d));
        //dd($d2-$d1);
        //dd($Calendar->jalali_to_gregorian('1355', '01', '13'));

    }
    public function herasat2()
    {
        $id_user = auth()->user()->id;
        $groups=DB::table('groupusers')->where('id_user', $id_user)->get()->toArray();
        return view('main_guard2',compact('groups'));
    }
    public function savabegh()
    {
        $id_user = auth()->user()->id;
        $groups=DB::table('groupusers')->where('id_user', $id_user)->get()->toArray();
        return view('test4',compact('groups'));
    }
    public function m_savabegh()
    {
        $id_user = auth()->user()->id;
        $groups=DB::table('groupusers')->where('id_user', $id_user)->get()->toArray();
        return view('test5',compact('groups'));
    }
    public function fsavabegh()
    {
        $id_user = auth()->user()->id;
        $groups=DB::table('groupusers')->where('id_user', $id_user)->get()->toArray();
        return view('test6',compact('groups'));
    }
    public function sms()
    {
        $mobile = [];

        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];

        $id_role=Role::where('role',"first_level_confirmation")->first()->id_role;
        $id_grs=Grouprole::where('id_role',$id_role)->get()->toArray();
        $id_users=Groupuser::where('id_gr',$id_grs[0]['id_gr'])->get()->toArray();
        $requests=Exit_goods_permission::where('level',1)->get()->toArray();
        foreach ($requests as $request) {
            $id_request_part=$request['id_request_part'];
            foreach ($id_users as $id_user){
                $target = DB::table('users')->where('id',$id_user['id_user'])->get()->toArray();
                $id_request_part_target=$target[0]->id_request_part;
                if($id_request_part_target==$id_request_part){
                    if(in_array($target[0]->mobile, $mobile))
                    {
                        continue;
                    }
                    else
                    {
                        array_push($mobile, $target[0]->mobile);
                        $values = array('date_shamsi_sms' => $date_shamsi,'id_user' => $id_user['id_user'],'description' => 'به نرم افزار مدیریت دریافت مجوز ورود و خروج بخش دریافت درخواست جدید مسئول مستقیم مراجعه شود','mobile' => $target[0]->mobile);
                        DB::table('smslists')->insert($values);
                    }
                }
            }
        }
    }
//    public function test2()
//    {
//        return view('test2');
//    }
    public function create()
    {
        $requests=Car::all();
        return view('car',compact('requests'));
    }
    public function delete($id)
    {
        Car::where('id_car', $id)->delete();
        $requests=Car::all();
        return view('car',compact('requests'));
    }
    public function edit(Request $request)
    {
        $car_no=$request->car_no;
        $driver_name=$request->driver_name;
        $id_car=$request->id_car;
        Car::where('id_car', $id_car)->update(['driver_name'=>$driver_name,'car_no'=>$car_no]);
        $requests=Car::all();
        return view('car',compact('requests'));
    }
    public function editform($id)
    {
        $request=Car::where('id_car', $id)->first();
        $car_no=$request->car_no;
        $driver_name=$request->driver_name;
        $id_car=$id;
        return view('caredit',compact('car_no','id_car','driver_name'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'car_no' => 'required|string|digits:6',
            'driver_name' => 'required|string|max:100',
        ]);
        Car::create($request->except('_token'));
        $requests=Car::all();
        return view('car',compact('requests'));
    }
}
