<?php

namespace App\Http\Controllers;

use App\Enteringeq;
use App\Enteringform;
use App\Enteringupload;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class enteringuploadsController extends Controller
{
    public function store_file(Request $request)
    {
        $sizev=0;
        $extentionv=0;
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $description_upload = $request->input('description_upload');
        $values = array('id_ef' => $id_ef,'upload_type' =>1,'description' => $description_upload,'id_user' => $id_user);
        DB::table('enteringuploads')->insert($values);
        $id_eup = DB::table('enteringuploads')->where('id_user',$id_user)->orderBy('id_eup', 'DESC')->first()->id_eup;
//
//        $validator = Validator::make($request->all(), [
//            'file'  => 'required|mimes:doc,docx,pdf,txt,xls,xlsx,png,jpg|max:2048',
//        ]);
        $file = $request->file('file');
        $extention=$file->getClientOriginalExtension();
        $size=$file->getSize();//2,097,152
        if($size>2097152){
            $sizev=0;
        }else{
            $sizev=1;
        }
        if($extention!='pdf'){
            $extentionv=0;
        }else{
            $extentionv=1;
        }
        if ($extentionv==1 && $sizev==1) {

//            request()->validate([
//                'file'  => 'required|mimes:pdf|max:2048',
//            ]);

            $new_name=$id_eup.'.'.$file->getClientOriginalExtension();;
            $file->move(public_path('documents'),$new_name);
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


            return Response()->json(["success" => true,"file" => $file,'id_eup'=>$id_eup,"ext" => $extentionv,'size'=>$sizev]);
        }else{
            return Response()->json(["success" => true,"ext" => $extentionv,'size'=>$sizev]);
        }
    }
    public function store_file2(Request $request)
    {
        $sizev=0;
        $extentionv=0;
        $id_user=auth()->user()->id;
        $id_ef = input('id_ef');
        $description_upload = $request->input('description_upload');
        $values = array('id_ef' => $id_ef,'upload_type' =>1,'description' => $description_upload,'id_user' => $id_user);
        DB::table('enteringuploads')->insert($values);
        $id_eup = DB::table('enteringuploads')->where('id_user',$id_user)->orderBy('id_eup', 'DESC')->first()->id_eup;
//
//        $validator = Validator::make($request->all(), [
//            'file'  => 'required|mimes:doc,docx,pdf,txt,xls,xlsx,png,jpg|max:2048',
//        ]);
        $file = $request->file('file');
        $extention=$file->getClientOriginalExtension();
        $size=$file->getSize();//2,097,152
        if($size>2097152){
            $sizev=0;
        }else{
            $sizev=1;
        }
        if($extention!='pdf'){
            $extentionv=0;
        }else{
            $extentionv=1;
        }
        if ($extentionv==1 && $sizev==1) {

//            request()->validate([
//                'file'  => 'required|mimes:pdf|max:2048',
//            ]);

            $new_name=$id_eup.'.'.$file->getClientOriginalExtension();;
            $file->move(public_path('documents'),$new_name);
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


            return Response()->json(["success" => true,"file" => $file,'id_eup'=>$id_eup,"ext" => $extentionv,'size'=>$sizev]);
        }else{
            return Response()->json(["success" => true,"ext" => $extentionv,'size'=>$sizev]);
        }
    }
    public function delete($id){

        Enteringupload::where('id_eup', $id)->delete();
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $eqs=Enteringeq::where('id_ef',$id_ef)->get()->count();
        $eup=Enteringupload::where('id_ef',$id_ef)->get()->count();
        if($eup==0 && $eqs==0){
            Enteringform::where('id_ef', $id_ef)->update(['s5'=>0,'permission3'=>0]);
        }

        return response()->json(['success'=>'hi','eup'=>$eup+$eqs]);
    }

}
