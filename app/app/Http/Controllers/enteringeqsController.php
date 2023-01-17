<?php

namespace App\Http\Controllers;

use App\Enteringeq;
use App\Enteringform;
use App\Enteringupload;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class enteringeqsController extends Controller
{
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $enteringeq=new Enteringeq();
        $enteringeq->id_ef=$id_ef;
        $enteringeq->id_user=$id_user;
        $enteringeq->description=$request->input('description');
        $enteringeq->save();
        Enteringform::where('id_ef', $id_ef)->update(['s5'=>1,'permission3'=>1]);

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

        $id_ee = DB::table('enteringeqs')->where('id_user',$id_user)->orderBy('id_ee', 'DESC')->first()->id_ee;
        return response()->json(['success'=>'hi','id_ee'=>$id_ee]);
    }
    public  function store2(Request $request){
        $id_user=auth()->user()->id;
        $id_ef = $request->input('id_ef');
        $enteringeq=new Enteringeq();
        $enteringeq->id_ef=$request->input('id_ef');
        $enteringeq->id_user=$id_user;
        $enteringeq->description=$request->input('description');
        $enteringeq->save();
        Enteringform::where('id_ef', $id_ef)->update(['s5'=>1,'permission3'=>1]);

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

        $id_ee = DB::table('enteringeqs')->where('id_user',$id_user)->orderBy('id_ee', 'DESC')->first()->id_ee;
        return response()->json(['success'=>'hi','id_ee'=>$id_ee]);
    }
    public function delete($id){

        Enteringeq::where('id_ee', $id)->delete();
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $eqs=Enteringeq::where('id_ef',$id_ef)->get()->count();
        $eup=Enteringupload::where('id_ef',$id_ef)->get()->count();
        if($eqs==0 && $eup==0){
            Enteringform::where('id_ef', $id_ef)->update(['s5'=>0,'level'=>0,'permission3'=>0]);
        }

        return response()->json(['success'=>'hi','eqs'=>$eqs+$eup]);
    }
    public function delete2($id){
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        Enteringeq::where('id_ee', $id)->delete();
        $eqs=Enteringeq::where('id_ef',$id_ef)->get()->count();
        if($eqs==0){
            Enteringform::where('id_ef', $id_ef)->update(['s5'=>0,'permission3'=>0]);
        }
        return response()->json(['success'=>'hi','data'=>$id,'eqs'=>$eqs]);
    }
    public function delete_all($id){

        Enteringeq::where('id_ef',$id)->delete();
        Enteringupload::where('id_ef',$id)->delete();
        return response()->json(['success'=>'hi']);
    }
    public function editeq(Request $request)
    {
        $id_ee=(int)$request->input('id_ee');
        $description=$request->input('description');
        Enteringeq::where('id_ee', $id_ee)->update(['description'=>$description]);
        return response()->json(['success'=>'the information has successfuly saved','id_ee'=>$id_ee,'description'=>$description]);

    }

}
