<?php

namespace App\Http\Controllers;

use App\Enteringform;
use App\Enteringin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class enteringinsController extends Controller
{
    public function store(Request $request){
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $enteringins=new Enteringin();
        $enteringins->id_ef=$id_ef;
        $enteringins->id_user=$id_user;
        $enteringins->description=$request->input('description');
        $enteringins->serial_no=$request->input('serial_no');
        $enteringins->save();
        Enteringform::where('id_ef', $id_ef)->update(['s4'=>1,'permission2'=>1]);

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
        $ins=Enteringin::where('id_ef',$id_ef)->get()->count();
        $id_ei = DB::table('enteringins')->where('id_user',$id_user)->orderBy('id_ei', 'DESC')->first()->id_ei;
        return response()->json(['success'=>'hi','id_ei'=>$id_ei,'ins'=>$ins]);
    }
    public function store2(Request $request){
        $id_user=auth()->user()->id;
        $id_ef = $request->input('id_ef');
        $enteringins=new Enteringin();
        $enteringins->id_ef=$request->input('id_ef');
        $enteringins->id_user=$id_user;
        $enteringins->description=$request->input('description');
        $enteringins->serial_no=$request->input('serial_no');
        $enteringins->save();
        Enteringform::where('id_ef', $id_ef)->update(['s4'=>1,'permission2'=>1]);

//        $s1=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s1;
//        $s2=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s2;
//        $s3=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s3;
//        $s4=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s4;
//        $s5=DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->s5;

//        if($s1==1 && $s2==1 && $s3==1 && $s4==1 && $s5==1){
//            Enteringform::where('id_ef', $id_ef)->update(['level'=>1]);
//        }else{
//            Enteringform::where('id_ef', $id_ef)->update(['level'=>0]);
//        }
        $ins=Enteringin::where('id_ef',$id_ef)->get()->count();
        $id_ei = DB::table('enteringins')->where('id_user',$id_user)->orderBy('id_ei', 'DESC')->first()->id_ei;
        return response()->json(['success'=>'hi','id_ei'=>$id_ei,'ins'=>$ins]);
    }
    public function delete($id){
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        Enteringin::where('id_ei', $id)->delete();
        $ins=Enteringin::where('id_ef',$id_ef)->get()->count();
        if($ins==0){
            Enteringform::where('id_ef', $id_ef)->update(['s4'=>0,'level'=>0,'permission2'=>0]);
        }
        return response()->json(['success'=>'hi','data'=>$id,'ins'=>$ins]);
    }
    public function delete2($id){
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        Enteringin::where('id_ei', $id)->delete();
        $ins=Enteringin::where('id_ef',$id_ef)->get()->count();
        if($ins==0){
            Enteringform::where('id_ef', $id_ef)->update(['s4'=>0,'permission2'=>0]);
        }
        return response()->json(['success'=>'hi','data'=>$id,'ins'=>$ins]);
    }
    public function delete_all($id){

        Enteringin::where('id_ef',$id)->delete();
        return response()->json(['success'=>'hi']);
    }
    public function editins(Request $request)
    {
        $id_ei=(int)$request->input('id_ei');
        $description=$request->input('description');
        $serial_no=$request->input('serial_no');
        Enteringin::where('id_ei', $id_ei)->update(['description'=>$description,'serial_no'=>$serial_no]);
        return response()->json(['success'=>'the information has successfuly saved','id_ei'=>$id_ei,'description'=>$description]);

    }
}
