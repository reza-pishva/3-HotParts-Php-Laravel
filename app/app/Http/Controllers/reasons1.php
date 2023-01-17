<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Exit_goods_permission;
use App\Goodstype;
use App\Request_level;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reasons1 extends Controller
{
    public function store(Request $request)
    {
        $requests=Exit_goods_permission::where('id_exit',$request->id_exit)->get()->first();
        //setting default values
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
        $id_request_part=$requests->id_request_part;
        $id_requester=$requests->id_requester;
        $id_exit =$request->id_exit;
        $mytime=Carbon::now();
        //inserting workflow updating request_level
        $values = array('level' => -1,
                        'id_exit' =>$id_exit,
                        'id_request_part' => $id_request_part,
                        'id_requester' => $id_requester,
                        'date_shamsi' => $date_shamsi,
                        'date_time' => $mytime,
                        'time_stamp' => $mytime->timestamp,
                        'reason'=>$request->reason);
        DB::table('workflows')->insert($values);
        Request_level::where('id_exit', $id_exit)->update(['level'=>-1]);
        //level->-1
        Exit_goods_permission::where('id_exit', $id_exit)->update(['level'=>-1]);
        //open page
        //$goodstypes=Goodstype::all();
        //$requests=Exit_goods_permission::where('id_request_part',$id_request_part)->where('level',1)->get();
        //return view('confirm1list',compact('requests','goodstypes'));
        $part = auth()->user()->id_request_part;
        $requests=Exit_goods_permission::where('id_request_part',$part)->where('level',-2)->get();
        $goodstypes=Goodstype::all();
        return view('return1list',compact('requests','goodstypes'));
    }
}
