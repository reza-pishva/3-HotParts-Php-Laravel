<?php

namespace App\Http\Controllers;

use App\CalendarHelper;
use App\Enteringform;
use App\Enteringhefazat;
use App\Enteringhefazatcase;
use App\Entering_personel_unique;
use App\Enteringpeaple;
use App\Enteringtitle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class enteringpeoplesController extends Controller
{
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($num, $persian, $string);
        return $englishNumbersOnly;
    }

    public  function store(Request $request){

        // $n=Entering_personel_unique::where('code_melli',$request->input('code_melli'))->get()->count();
        // if($n == 0){
        //     DB::table('entering_personel_uniques')->insert([
        //         'f_name' => $request->input('f_name'),
        //         'l_name' => $request->input('l_name'),
        //         'code_melli' => $request->input('code_melli')
        //     ]);
        // }


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
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $enteringpeaple=new Enteringpeaple();
        $enteringpeaple->f_name=$request->input('f_name');
        $enteringpeaple->l_name=$request->input('l_name');
        $enteringpeaple->code_melli=$request->input('code_melli');
        $code=$request->input('code_melli');
        $enteringpeaple->mobile=$request->input('mobile');

        $date_shamsi_enter = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->date_shamsi_enter;
        $date_shamsi_exit = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->date_shamsi_exit;
        $time_enter = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->time_enter;
        $time_exit = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->time_exit;

        $enteringpeaple->time_enter=$time_enter;

        $enteringpeaple->date_shamsi_enter=$date_shamsi_enter;
        $enteringpeaple->time_exit=$time_exit;
        $enteringpeaple->date_shamsi_exit=$date_shamsi_exit;


        $string=$date_shamsi_exit;
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $date_no2=str_replace($persian,$num, $string);
        $string=$date_shamsi_enter;
        $date_no1=str_replace($persian,$num, $string);


        $enteringpeaple->id_et=(int)$request->input('id_et');
        $enteringpeaple->nationality=$request->input('nationality');
        $enteringpeaple->id_ef=$id_ef;
        $enteringpeaple->id_user=$id_user;


        ////-----------------------------------------------------------------------------------------------------
        if(DB::table('enteringpeaples')->where('code_melli','=',$code)->exists()){
            $date1 = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ep', 'DESC')->first()->date_shamsi_enter;
            $date2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ep', 'DESC')->first()->date_shamsi_exit;
            $date_no1_p= str_replace($persian,$num, $date1);
            $date_no2_p= str_replace($persian,$num, $date2);
        }
        else{
            $date_no1_p=0;
            $date_no2_p=0;
        }
        $title2 = DB::table('enteringforms')->where('id_ef','=',$id_ef)->first()->title;
        $company = DB::table('enteringforms')->where('id_ef','=',$id_ef)->first()->company;

        if(($date_no1>$date_no2_p) and ($date_no1<=$date_no2)){

            $enteringpeaple->save();
            $id_ep = DB::table('enteringpeaples')->where('id_ef',$id_ef)->orderBy('id_ep', 'DESC')->first()->id_ep;
            Enteringpeaple::where('code_melli', $code)->update(['notlet2'=>0]);
            $id_request_part = DB::table('enteringforms')->where('id_ef',$id_ef)->orderBy('id_ef', 'DESC')->first()->id_request_part;
            Enteringform::where('id_ef', $id_ef)->update(['s2'=>1]);
            Enteringpeaple::where('id_ep', $id_ep)->update(['date_no2'=>(int)$date_no2]);
            Enteringpeaple::where('id_ep', $id_ep)->update(['date_no1'=>(int)$date_no1]);
            Enteringpeaple::where('id_ef', $id_ef)->update(['id_request_part'=>$id_request_part]);
            $people=Enteringpeaple::where('id_ef',$id_ef)->get()->count();
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
            $id_ep = DB::table('enteringpeaples')->where('id_ef',$id_ef)->orderBy('id_ep', 'DESC')->first()->id_ep;
            Enteringpeaple::where('id_ep', $id_ep)->update(['notlet1'=>0,'notlet2'=>0]);
            return response()->json(['success'=>'hi','id_ep'=>$id_ep,'people'=>$people,'id_ef'=>$id_ef,
                'date_no1_p'=>$date_no1_p,'date_no2_p'=>$date_no2_p,
                'date_no1'=>$date_no1,'date_no2'=>$date_no2,
                'reapeted'=>0,'d_en'=>$date_shamsi_enter,'d_ex'=>$date_shamsi_exit,'t_en'=>$time_enter,'t_ex'=>$time_exit]);

        }else{
            return response()->json(['success'=>'hi','reapeted'=>1,'date1'=>$date_no1_p,'date2'=>$date_no2_p,
                'date_no1_p'=>$date_no1_p,'date_no2_p'=>$date_no2_p,
                'date_no1'=>$date_no1,'date_no2'=>$date_no2,
                'company'=>$company,'title'=>$title2,'id_ef'=>$id_ef,
                'reapeted'=>1]);
        }







    }


    public function delete($id){
        $id_user=auth()->user()->id;
        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
        Enteringpeaple::where('id_ep', $id)->delete();
        $peaple=Enteringpeaple::where('id_ef',$id_ef)->get()->count();
        if($peaple==0){
            Enteringform::where('id_ef', $id_ef)->update(['s2'=>0,'level'=>0]);
        }
        return response()->json(['success'=>'hi','data'=>$id,'people'=>$peaple]);
    }
    public function delete2($id){
        Enteringpeaple::where('id_ep', $id)->delete();
        return response()->json(['success'=>'hi','data'=>$id]);
    }
    public function editform1(Request $request)
    {
        // $n=Entering_personel_unique::where('code_melli',$request->input('code_melli'))->get()->count();
        // if($n == 0){
        //     DB::table('entering_personel_uniques')->insert([
        //         'f_name' => $request->input('f_name'),
        //         'l_name' => $request->input('l_name'),
        //         'code_melli' => $request->input('code_melli')
        //     ]);
        // }

        $id_user=auth()->user()->id;

        $id_ep=$request->input('id_ep');
        $f_name=$request->input('f_name');
        $l_name=$request->input('l_name');
        $nationality=$request->input('nationality');
        $age=$request->input('age');
        $code_melli=$request->input('code_melli');
        $mobile=$request->input('mobile');
        $time_enter=$request->input('time_enter');
        $date_shamsi_enter=$request->input('date_shamsi_enter');
        $date_shamsi_enter_array=explode('/',$date_shamsi_enter);
        $date_shamsi_enter=$date_shamsi_enter_array[0].$date_shamsi_enter_array[1].$date_shamsi_enter_array[2];
        $time_exit=$request->input('time_exit');
        $date_shamsi_exit=$request->input('date_shamsi_exit');
        $date_shamsi_exit_array=explode('/',$date_shamsi_exit);
        $date_shamsi_exit=$date_shamsi_exit_array[0].$date_shamsi_exit_array[1].$date_shamsi_exit_array[2];
        $id_et=(int)$request->input('id_et');

        $string= $date_shamsi_exit;
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $date_no2= str_replace($persian,$num, $string);
        $string= $date_shamsi_enter;
        $date_no1= str_replace($persian,$num, $string);
        $persons_no= DB::table('enteringpeaples')->where('code_melli',$code_melli)->count();
        $persons2= DB::table('enteringpeaples')->where('code_melli',$code_melli)->get()->toArray();

//        $code_p = DB::table('enteringpeaples')->where('id_ep',$id_ep)->first()->code_melli;


            foreach ($persons2 as $person2) {
                if($person2->id_ep != $id_ep){
                    $code_p=$person2->code_melli;
                    $date1 = DB::table('enteringpeaples')->where('id_ep',$person2->id_ep)->first()->date_no1;
                    $date2 = DB::table('enteringpeaples')->where('id_ep',$person2->id_ep)->first()->date_no2;

                    $date_no1_p= str_replace($persian,$num, $date1);
                    $date_no2_p= str_replace($persian,$num, $date2);

                    if(($date_no1>=$date_no2_p) and ($date_no1<=$date_no2) and ($date_no1>$date_no1_p)){
                        Enteringpeaple::where('id_ep', $id_ep)->update([
                            'date_no1'=>$date_no1,
                            'date_no2'=>$date_no2,
                            'date_shamsi_enter'=>$date_shamsi_enter,
                            'date_shamsi_exit'=>$date_shamsi_exit,
                            'time_enter'=>$time_enter,
                            'time_exit'=>$time_exit,
                            'f_name' => $f_name,
                            'l_name' => $l_name,
                            'code_melli' => $code_melli,
                            'mobile' => $mobile,
                            'nationality' => $nationality,
                            'age' => $age,
                            'id_et' => $id_et]);
                        return response()->json(['repeat' => 0,'id_ep'=>$id_ep]);
                    }
                    return response()->json(['repeat' => 1]);
                }
            }
            if($persons_no==1 or $persons_no==0){
                if($date_no1<=$date_no2){
                    Enteringpeaple::where('id_ep', $id_ep)->update([
                        'date_no1'=>$date_no1,
                        'date_no2'=>$date_no2,
                        'date_shamsi_enter'=>$date_shamsi_enter,
                        'date_shamsi_exit'=>$date_shamsi_exit,
                        'time_enter'=>$time_enter,
                        'time_exit'=>$time_exit,
                        'f_name' => $f_name,
                        'l_name' => $l_name,
                        'code_melli' => $code_melli,
                        'mobile' => $mobile,
                        'nationality' => $nationality,
                        'age' => $age,
                        'id_et' => $id_et]);
                    return response()->json(['repeat' => 0,'id_ep'=>$id_ep]);
                }else{
                    return response()->json(['repeat' => 1,'id_ep'=>$id_ep]);
                }
            }

    }
    public function editform2(Request $request)
    {
        $id_user=auth()->user()->id;

        $id_ep=$request->input('id_ep');
        $f_name=$request->input('f_name');
        $l_name=$request->input('l_name');
        $nationality=$request->input('nationality');
        $age=$request->input('age');
        $code_melli=$request->input('code_melli');
        $mobile=$request->input('mobile');
        $time_enter=$request->input('time_enter');
        $date_shamsi_enter=$request->input('date_shamsi_enter');
        $date_shamsi_enter_array=explode('/',$date_shamsi_enter);
        $date_shamsi_enter=$date_shamsi_enter_array[0].$date_shamsi_enter_array[1].$date_shamsi_enter_array[2];
        $time_exit=$request->input('time_exit');
        $date_shamsi_exit=$request->input('date_shamsi_exit');
        $date_shamsi_exit_array=explode('/',$date_shamsi_exit);
        $date_shamsi_exit=$date_shamsi_exit_array[0].$date_shamsi_exit_array[1].$date_shamsi_exit_array[2];
        $id_et=(int)$request->input('id_et');

        $string= $date_shamsi_exit;
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $date_no2= str_replace($persian,$num, $string);
        $string= $date_shamsi_enter;
        $date_no1= str_replace($persian,$num, $string);
        $persons_no= DB::table('enteringpeaples')->where('code_melli',$code_melli)->count();
        $persons2= DB::table('enteringpeaples')->where('code_melli',$code_melli)->get()->toArray();

        // $n=Entering_personel_unique::where('code_melli',$request->input('code_melli'))->get()->count();
        // if($n == 0){
        //     DB::table('entering_personel_uniques')->insert([
        //         'f_name' => $request->input('f_name'),
        //         'l_name' => $request->input('l_name'),
        //         'code_melli' => $request->input('code_melli')
        //     ]);
        // }


                    Enteringpeaple::where('id_ep', $id_ep)->update([
                        'date_no1'=>$date_no1,
                        'date_no2'=>$date_no2,
                        'date_shamsi_enter'=>$date_shamsi_enter,
                        'date_shamsi_exit'=>$date_shamsi_exit,
                        'time_enter'=>$time_enter,
                        'time_exit'=>$time_exit,
                        'f_name' => $f_name,
                        'l_name' => $l_name,
                        'code_melli' => $code_melli,
                        'mobile' => $mobile,
                        'nationality' => $nationality,
                        'age' => $age,
                        'id_et' => $id_et]);
                    return response()->json(['repeat' => 0,'id_ep'=>$id_ep]);












//        Enteringpeaple::where('id_ep', $id_ep)->update([
//            'date_no1'=>$date_no1,
//            'date_no2'=>$date_no2,
//            'date_shamsi_enter'=>$date_shamsi_enter,
//            'date_shamsi_exit'=>$date_shamsi_exit,
//            'time_enter'=>$time_enter,
//            'time_exit'=>$time_exit,
//            'f_name' => $f_name,
//            'l_name' => $l_name,
//            'code_melli' => $code_melli,
//            'mobile' => $mobile,
//            'nationality' => $nationality,
//            'age' => $age,
//            'id_et' => $id_et]);
//        return response()->json(['repeat' => 0]);
    }
//    public function editform2(Request $request)
//    {
//        $id_user=auth()->user()->id;
//        $id_ef = DB::table('enteringforms')->where('id_user',$id_user)->orderBy('id_ef', 'DESC')->first()->id_ef;
//        $id_ep=$request->input('id_ep');
//        $f_name=$request->input('f_name');
//        $l_name=$request->input('l_name');
//        $nationality=$request->input('nationality');
//        $age=$request->input('age');
//        $code_melli=$request->input('code_melli');
//        $mobile=$request->input('mobile');
//        $time_enter=$request->input('time_enter');
//        $date_shamsi_enter=$request->input('date_shamsi_enter');
//        $date_shamsi_enter_array=explode('/',$date_shamsi_enter);
//        $date_shamsi_enter=$date_shamsi_enter_array[0].$date_shamsi_enter_array[1].$date_shamsi_enter_array[2];
//        $time_exit=$request->input('time_exit');
//        $date_shamsi_exit=$request->input('date_shamsi_exit');
//        $date_shamsi_exit_array=explode('/',$date_shamsi_exit);
//        $date_shamsi_exit=$date_shamsi_exit_array[0].$date_shamsi_exit_array[1].$date_shamsi_exit_array[2];
//        $id_et=(int)$request->input('id_et');
//
//
////        $date_shamsi_enter = DB::table('enteringforms')->where('id_ef',$id_ef)->first()->date_shamsi_enter;
////        $date_shamsi_exit = DB::table('enteringforms')->where('id_ef',$id_ef)->first()->date_shamsi_exit;
////        $time_enter = DB::table('enteringforms')->where('id_ef',$id_ef)->first()->time_enter;
////        $time_exit = DB::table('enteringforms')->where('id_ef',$id_ef)->first()->time_exit;
//            Enteringpeaple::where('id_ep', $id_ep)->update([
//                'date_shamsi_enter' => $date_shamsi_enter,
//                'date_shamsi_exit' => $date_shamsi_exit,
//                'time_enter' => $time_enter,
//                'time_exit' => $time_exit,
//                'f_name' => $f_name,
//                'l_name' => $l_name,
//                'code_melli' => $code_melli,
//                'mobile' => $mobile,
//                'nationality' => $nationality,
//                'age' => $age,
//                'id_et' => $id_et
//                ]);
//            return response()->json(['success' => 'the information has successfuly saved', 'id_ep' => $id_ep]);
//
//    }
//    public function editform2(Request $request)
//    {
//        $id_ep=$request->input('id_ep');
//        $f_name=$request->input('f_name');
//        $l_name=$request->input('l_name');
//        $nationality=$request->input('nationality');
//        $age=$request->input('age');
//        $code_melli=$request->input('code_melli');
//        $code=$request->input('code_melli');
//        $mobile=$request->input('mobile');
//        $time_enter=$request->input('time_enter');
//        $date_shamsi_enter=$request->input('date_shamsi_enter');
//        $date_shamsi_enter_array=explode('/',$date_shamsi_enter);
//        $date_shamsi_enter=$date_shamsi_enter_array[0].$date_shamsi_enter_array[1].$date_shamsi_enter_array[2];
//        $time_exit=$request->input('time_exit');
//        $date_shamsi_exit=$request->input('date_shamsi_exit');
//        $date_shamsi_exit_array=explode('/',$date_shamsi_exit);
//        $date_shamsi_exit=$date_shamsi_exit_array[0].$date_shamsi_exit_array[1].$date_shamsi_exit_array[2];
//        $id_et=(int)$request->input('id_et');
//        $string=$date_shamsi_exit_array[0].$date_shamsi_exit_array[1].$date_shamsi_exit_array[2];
//        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
//        $num = range(0, 9);
//        $date_no1=$englishNumbersOnly = str_replace($persian,$num, $string);
//        $string=$date_shamsi_enter_array[0].$date_shamsi_enter_array[1].$date_shamsi_enter_array[2];
//        $date_no2=$englishNumbersOnly = str_replace($persian,$num, $string);
//
//
////        -------------------------current record---------------------------------------------------
//        $id_ef_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->id_ef;
//        $id_et_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->id_et;
//        $id_user_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->id_user;
//        $f_name_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->f_name;
//        $l_name_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->l_name;
//        $nationality_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->$nationality;
//        $code_melli_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->code_melli;
//        $mobile_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->mobile;
//        $time_enter_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->time_enter;
//        $date_shamsi_enter_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->date_shamsi_enter;
//        $time_exit_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->time_exit;
//        $date_shamsi_exit_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->date_shamsi_exit;
//        $cond1_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->cond1;
//        $cond2_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->cond2;
//        $cond3_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->cond3;
//        $cond4_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->cond4;
//        $cond5_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->cond5;
//        $cond6_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->cond6;
//        $cardno_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->cardno;
//        $let_show_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->let_show;
//        $presence_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->presence;
//        $date_no1_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->date_no1;
//        $date_no2_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->date_no2;
//        $id_request_part_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->id_request_part;
//        $notlet1_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->not_let1;
//        $notlet2_p = DB::table('enteringpeaples')->where('id_ep','=',$id_ep)->first()->not_let2;
////------------------------------------------------------------------------------------------------------------------------------
//        $date1 = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->date_shamsi_enter;
//        $date2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->date_shamsi_exit;
//        $date_no1_p= str_replace($persian,$num, $date1);
//        $date_no2_p= str_replace($persian,$num, $date2);
//
//        Enteringpeaple::where('id_ep', $id_ep)->delete();
//        if(($date_no1>$date_no2_p) and ($date_no1<=$date_no2)){
//            $enteringpeaple=new Enteringpeaple();
//            $enteringpeaple->save();
//            $id_ep = DB::table('enteringpeaples')->where('id_ef',$id_ef_p)->orderBy('id_ep', 'DESC')->first()->id_ep;
//            Enteringpeaple::where('id_ep', $id_ep)->update(['id_ef'=>$id_ef_p,'id_user'=>$id_user_p,'cond1'=>$cond1_p,'cond1'=>$cond1_p,'cond2'=>$cond2_p,
//                'cond3'=>$cond3_p,'cond4'=>$cond4_p,'cond5'=>$cond5_p,'cond6'=>$cond6_p,'card_no'=>$cardno_p,'let_show'=>$let_show_p,'presence'=>$presence_p,
//                'id_request_part'=>$id_request_part_p,'notlet1'=>0,'notlet2'=>0]);
//        }else{
//            $values = array('id_ef' => $id_ef_p ,'id_et' =>$id_et_p,'id_user' => $id_user_p,
//            'f_name' => $f_name_p,'l_name' =>$l_name_p,'nationality' =>$nationality_p,'code_melli' =>$code_melli_p,
//            'age' =>"0",'mobile' =>$mobile_p,'time_enter' =>$time_enter_p,'date_shamsi_enter' =>$date_shamsi_enter_p,'time_exit' =>$time_exit_p,
//            'date_shamsi_exit' =>$date_shamsi_exit_p,'cond1' =>$cond1_p,'cond6' =>$cond6_p,'cond2' =>$cond2_p,'cond3' =>$cond3_p,'cond4' =>$cond4_p,'cond5' =>$cond5_p
//            ,'card_no' =>$cardno_p,'let_show' =>$let_show_p,'presence' =>$presence_p,'date_no1' =>$date_no1_p,'date_no2' =>$date_no2_p,
//             'id_request_part' =>$id_request_part_p,'notlet1' =>$notlet1_p,'notlet2' =>$notlet2_p);
//            DB::table('enteringpeaples')->insert($values);
//        }
//    }
//    public function editform3(Request $request)
//    {
//        $id_ep=$request->input('id_ep');
//        return response()->json(['success'=>'the information has successfuly saved','id_ep'=>$id_ep]);
//    }
    public function hefazat_cond($id)
    {
        $id_ef = DB::table('enteringpeaples')->where('id_ep',$id)->orderBy('id_ep', 'DESC')->first()->id_ef;
        $f_name = DB::table('enteringpeaples')->where('id_ep',$id)->orderBy('id_ep', 'DESC')->first()->f_name;
        $l_name = DB::table('enteringpeaples')->where('id_ep',$id)->orderBy('id_ep', 'DESC')->first()->l_name;
        $title = DB::table('enteringforms')->where('id_ef',$id_ef)->orderBy('id_ef', 'DESC')->first()->title;
        $company = DB::table('enteringforms')->where('id_ef',$id_ef)->orderBy('id_ef', 'DESC')->first()->company;
        $cond1 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->cond1;
        $cond2 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->cond2;
        $cond3 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->cond3;
        $cond4 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->cond4;
        $cond5 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->cond5;
        $cond6 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->cond6;
        $cardno = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->cardno;
        return response()->json(['cond1'=> $cond1,'cond2'=> $cond2,'cond3'=> $cond3,'cond4'=> $cond4,'cond5'=> $cond5,'cond6'=> $cond6,
            'cardno'=>$cardno,'id_ef'=>$id_ef,'f_name'=>$f_name,'l_name'=>$l_name,'title'=>$title,'company'=>$company]);
    }
    public function person_info($id)
    {
        $id_ef = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->id_ef;
        $hefazat = Enteringhefazat::where('id_ep', $id)->orderBy('id_ep', 'DESC')->get()->toArray();
        $title = Enteringform::where('id_ef', $id_ef)->orderBy('id_ef', 'DESC')->first()->title;
        $company = Enteringform::where('id_ef', $id_ef)->orderBy('id_ef', 'DESC')->first()->company;
        $id_et = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->id_et;
        $f_name = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->f_name;
        $l_name = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->l_name;
        $date1 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->date_shamsi_enter;
        $time1 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->time_enter;
        $date2 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->date_shamsi_exit;
        $time2 = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->time_exit;
        $nationality = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->nationality;
        $code_melli = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->code_melli;
        $age = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->age;
        $mobile = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->mobile;
        $cardno = Enteringpeaple::where('id_ep', $id)->orderBy('id_ep', 'DESC')->first()->cardno;
        $job = Enteringtitle::where('id_et', $id_et)->orderBy('id_et', 'DESC')->first()->description;
        return response()->json(['id_ep'=>$id,'f_name'=>$f_name,'l_name'=>$l_name,'job'=>$job,'nationality'=>$nationality,'age'=> $age,'date1'=> $date1,'time1'=> $time1
            ,'date2'=> $date2,'time2'=> $time2 ,'code_melli'=> $code_melli,'mobile'=> $mobile,'hefazat'=>$hefazat,'title2'=>$title,'company2'=>$company,'cardno'=>$cardno]);
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
        $let_show = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->let_show;
        $date1 = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->date_shamsi_enter;
        $date2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->date_shamsi_exit;
        $id_ep = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->id_ep;
        $id_ef = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $cardno = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ef', 'DESC')->first()->cardno;
        $title2 = DB::table('enteringforms')->where('id_ef','=',$id_ef)->first()->title;
        $company = DB::table('enteringforms')->where('id_ef','=',$id_ef)->first()->company;
        $persons = DB::table('enteringpeaples')->where('code_melli','=',$code)->where('let_show','=',1)->get()->toArray();
        $hefazat = DB::table('enteringhefazats')->where('id_ep', $id_ep)->orderBy('id_ep', 'DESC')->get()->toArray();
        return response()->json(['results'=> $persons,'titles'=> $titles,'job'=> $title2,'company'=>$company,'cardno'=>$cardno,'hefazat'=>$hefazat,'date1'=>$date1,'date2'=>$date2,'date'=>$current_date_shamsi,'count_record'=>$code,'let_show'=>$let_show,'id_ef'=>$id_ef,'id_ep'=>$id_ep]);//,'title'=>$title,'company'=>$company
    }
    public function person_info2($code)
    {
        $f_name = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->f_name;
        $l_name = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->l_name;
        return response()->json(['f_name'=> $f_name,'l_name'=> $l_name]);//,'title'=>$title,'company'=>$company
    }
    public function set_block($id)
    {
        Enteringpeaple::where('id_ep', $id)->update(['notlet1'=>1,'notlet2'=>1]);
        return response()->json(['success'=> 'hi']);
    }
    public function reset_block($id)
    {
        Enteringpeaple::where('id_ep', $id)->update(['notlet1'=>1,'notlet2'=>0]);
        return response()->json(['success'=> 'hi']);
    }
    public function auth_duration_not_block()
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
        $data =  DB::table('enteringpeaples')->where('date_shamsi_enter','<=',$current_date_shamsi)->where('date_shamsi_exit','>=',$current_date_shamsi)->where('let_show',1)->where('notlet2','0')->orderBy('id_ep','DESC')->get()->toArray();
        return response()->json(['results'=>$data,'titles'=>$titles]);
    }
    public function auth_duration_not_block2()
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
        $data =  DB::table('enteringpeaples')->where('date_shamsi_exit','>=',$current_date_shamsi)->where('let_show',1)->where('notlet2','0')->orderBy('id_ep','DESC')->get()->toArray();
        return response()->json(['results'=>$data,'titles'=>$titles]);
    }
    public function auth_duration_block()
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
        $data =  DB::table('enteringpeaples')->where('notlet2','=','1')->get()->toArray();
        return response()->json(['results'=>$data,'titles'=>$titles]);
    }
    public function block_history()
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
        $data = DB::table('enteringpeaples')->where('notlet1','1')->orderBy('id_ep', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'titles'=>$titles]);
    }
    public function enterexit_history($code)
    {
        $data = DB::table('enteringpeaples')->where('code_melli',$code)->orderBy('id_ep', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function get_date12($code)
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
        $date1 = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->date_shamsi_enter;
        $date2 = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->date_shamsi_exit;
        $id_ep = DB::table('enteringpeaples')->where('code_melli','=',$code)->first()->id_ep;
        $id_ef = DB::table('enteringpeaples')->where('code_melli','=',$code)->orderBy('id_ef', 'DESC')->first()->id_ef;
        $title2 = DB::table('enteringforms')->where('id_ef','=',$id_ef)->first()->title;
        $company = DB::table('enteringforms')->where('id_ef','=',$id_ef)->first()->company;
        return response()->json(['job'=> $title2,'company'=>$company,'date1'=>$date1,'date2'=>$date2,'date'=>$current_date_shamsi,'count_record'=>$code,'id_ef'=>$id_ef]);
    }
    public function exist_peaple()
    {
        $data = DB::table('enteringpeaples')->where('presence',1)->orderBy('id_ep', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function exist_peaple2()
    {
        $data = DB::table('enteringpeaples')->where('presence',1)->orderBy('id_ep', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
}
