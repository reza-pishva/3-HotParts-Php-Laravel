<?php
namespace App\Http\Controllers;



use App\Ansaldo_bazsaz;
use App\Ansaldo_buy_ghataat;
use App\Ansaldo_ghataat;
use App\Ansaldo_group_name;
use App\Ansaldo_nirogah_name;
use App\Ansaldo_out_ghataat;
use App\Ansaldo_resv_bazsazi_ghataat;
use App\Ansaldo_savabegh;
use App\Ansaldo_seller;
use App\Ansaldo_send_bazsazi_ghataat;
use App\Ansaldo_store_program_in;
use App\Ansaldo_store_program_out;
use App\Ansaldo_tamirat_program;
use App\Ansaldo_tamirat_type;
use App\Ansaldo_tamirkaran;
use App\Ansaldo_type_ghataat;
use App\Ansaldo_unit_number;
use App\Querytext;
use App\User;
use App\CalendarHelper;
use Carbon\Carbon;
use App\Grouprole;
use App\Groupuser;
use App\Request_level;
use App\Role;
use App\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AnsaldoSavabeghController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $atp= new Ansaldo_group_name();
        $atp->ID_TG=$request->input('ID_TG');
        $atp->GROUP_CODE=$request->input('GROUP_CODE');
        $atp->GROUP_TYPE=$request->input('GROUP_TYPE');
        $atp->ID_USER=$id_user;
        $atp->save();
        return response()->json(['message'=> 'hi']);
    }
    public function create()
    {
                                //--access level-----
                                $user = auth()->user()->id;
                                $f_name=auth()->user()->f_name;
                                $l_name=auth()->user()->l_name;
                                $full_name=$f_name.' '.$l_name;
                                $groupusers=Groupuser::where('id_user',$user)->get()->toArray();
                                $allow=0;
                                foreach ($groupusers as $groupuser) {
                                    $grouproles=Grouprole::where('id_gr',$groupuser['id_gr'])->get()->toArray();
                                    foreach ($grouproles as $grouprole) {
                        
                                        $role_name=Role::where('id_role',$grouprole['id_role'])->first();
                                        if($role_name['role'] ==="admin" or $role_name['role'] ==="track_savabegh_insert"){
                                            $allow=1;
                                            $g_y = Carbon::now()->year;
                                            $g_m = Carbon::now()->month;
                                            $g_d = Carbon::now()->day;
                                            $Calendar=new CalendarHelper();
                                            $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                                            $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                                            $mytime=Carbon::now();
                                            $part = auth()->user()->id_request_part;
                                            $sellers=Ansaldo_seller::all();
                                            $anns=Ansaldo_nirogah_name::all();
                                            $tgs=Ansaldo_type_ghataat::all();
                                            $auns=Ansaldo_unit_number::all();
                                            $atts=Ansaldo_tamirat_type::all();
                                            $ats=Ansaldo_tamirkaran::all();
                                            $bas=Ansaldo_bazsaz::all();
                                            $requests = Ansaldo_group_name::all();
                                            $ghataats =Ansaldo_type_ghataat::all();
                                            $sazs = DB::table('ansaldo_sazandehs')->where('ID_S','>',0)->get()->toArray();
                                            return view('Ansaldo.ansaldo_savabegh_insert',compact('requests','ghataats','sazs','anns','auns','atts','ats','bas','tgs','sellers'));
                                        }
                        
                                    }
                                }
                        
                                if($allow===0){
                                    return view('access_denied');
                                }
                                //--access level-----
       
    }
    public function create_search_by_ide()
    {
                                //--access level-----
                                $user = auth()->user()->id;
                                $f_name=auth()->user()->f_name;
                                $l_name=auth()->user()->l_name;
                                $full_name=$f_name.' '.$l_name;
                                $groupusers=Groupuser::where('id_user',$user)->get()->toArray();
                                $allow=0;
                                foreach ($groupusers as $groupuser) {
                                    $grouproles=Grouprole::where('id_gr',$groupuser['id_gr'])->get()->toArray();
                                    foreach ($grouproles as $grouprole) {
                        
                                        $role_name=Role::where('id_role',$grouprole['id_role'])->first();
                                        if($role_name['role'] ==="admin" or $role_name['role'] ==="track_savabegh_insert"){
                                            $allow=1;
                                            $g_y = Carbon::now()->year;
                                            $g_m = Carbon::now()->month;
                                            $g_d = Carbon::now()->day;
                                            $Calendar=new CalendarHelper();
                                            $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                                            $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                                            $mytime=Carbon::now();
                                            $part = auth()->user()->id_request_part;
                                            $sellers=Ansaldo_seller::all();
                                            $anns=Ansaldo_nirogah_name::all();
                                            $tgs=Ansaldo_type_ghataat::all();
                                            $auns=Ansaldo_unit_number::all();
                                            $atts=Ansaldo_tamirat_type::all();
                                            $ats=Ansaldo_tamirkaran::all();
                                            $bas=Ansaldo_bazsaz::all();
                                            $requests = Ansaldo_group_name::all();
                                            $ghataats =Ansaldo_type_ghataat::all();
                                            $sazs = DB::table('ansaldo_sazandehs')->where('ID_S','>',0)->get()->toArray();
                                            return view('Ansaldo.ansaldo_savabegh_search_by_ide',compact('requests','ghataats','sazs','anns','auns','atts','ats','bas','tgs','sellers'));
                                        }
                        
                                    }
                                }
                        
                                if($allow===0){
                                    return view('access_denied');
                                }
                                //--access level-----
       
    }
    public function total()
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_group_names')->where('ID_G','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    public function total2($id)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_ghataats')->where('ID_G',$id)->orderBy('ID_E', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    public function total_today()
    {
        $id_user = auth()->user()->id;
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
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_group_names')->where('ID_G','>',0)->where('ID_USER',$id_user)->where('DATE_SHAMSI','>=',$current_date_shamsi)->orderBy('ID_G', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3,'current_date_shamsi'=>$g_d]);//->where('DATE_BEGIN1',$current_date_shamsi)
    }
    public function get_history($id)
    {
        $tamir_prog = Ansaldo_tamirat_program::all();
        $bazsazi_prog1 = Ansaldo_send_bazsazi_ghataat::all();
        $bazsazi_prog2 = Ansaldo_resv_bazsazi_ghataat::all();
        $anbar_prog1 = Ansaldo_store_program_in::all();
        $anbar_prog2 = Ansaldo_store_program_out::all();
        $buy_prog1 = Ansaldo_buy_ghataat::all();
        $eex_prog1=Ansaldo_out_ghataat::all();

        $id_bas = Ansaldo_bazsaz::all();
        $id_tts = Ansaldo_tamirat_type::all();
        $id_tas = Ansaldo_tamirkaran::all();
        $id_un = Ansaldo_unit_number::all();
        $id_se = Ansaldo_seller::all();
        $data = DB::table('ansaldo_savabeghs')->where('ID_E',$id)->get()->toArray();
        return response()->json(['results'=> $data,'tamir_prog'=>$tamir_prog,'id_tts'=>$id_tts,'id_tas'=>$id_tas,'id_uns'=>$id_un,'id_se'=>$id_se,'bazsazi1'=>$bazsazi_prog1,'bazsazi2'=>$bazsazi_prog2,'id_bas'=>$id_bas,'anbar1'=>$anbar_prog1,'anbar2'=>$anbar_prog2,'buy1'=>$buy_prog1,'eex'=>$eex_prog1]);
    }
    public function onlyone2($id)
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_group_names')->where('ID_G',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    public function delete($id){
            Ansaldo_savabegh::where('ID_S', $id)->delete();
            return response()->json(['success'=>'hi']);
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function savabegh_insert($type_sabegheh,$mizan_kharabi,$vaz_nasb,$karkard,$description,$id_t1,$id_sub,$id_g_global,$insert_type,$ghataat4,$radif1,$radif2,$program,$id_t_bazsazi1,$id_t_bazsazi2){
        if($mizan_kharabi==1){
            $mizan_kharabi='سالم و تمیزکاری';
        }
        if($mizan_kharabi==2){
            $mizan_kharabi='سبک';
        }
        if($mizan_kharabi==3){
            $mizan_kharabi='متوسط';
        }
        if($mizan_kharabi==4){
            $mizan_kharabi='سنگین';
        }
        if($vaz_nasb==1){
            $vaz_nasb='مونتاژ';
        }
        if($vaz_nasb==2){
            $vaz_nasb='دمونتاژ';
        }
        if($vaz_nasb==3){
            $vaz_nasb='دمونتاژ و مونتاژ';
        }
        if($vaz_nasb==4){
            $vaz_nasb='بدون تغییر';
        }
        if($program>=1){
            if($insert_type==1){

                $n= Ansaldo_savabegh::where('ID_E',$ghataat4)->where('ID_T',$id_t1)->get()->count();
                if($n){
                    if($n>0){
                        return response()->json(['success'=>'hi','reapeted_no'=>$ghataat4,'insert_type'=>1]);
                    }
                }
                DB::table('ansaldo_savabeghs')->insert([
                    'ID_E' => $ghataat4,
                    'ID_T' => $id_t1,
                    'ID_SUB' => $id_sub,
                    'TIME_WORK' => $karkard,
                    'DAMAGE_PERCENT' => $mizan_kharabi,
                    'TYPE_INSTAL' => $vaz_nasb,
                    'DISCRIPTION' => $description,
                    'SAV_TYPE' => $type_sabegheh
                ]);

                return response()->json(['success'=>'hi','id_e'=>$ghataat4,'insert_type'=>1]);
            }
            if($insert_type==2){
                $ghataat_count=0;
                $ghataats= Ansaldo_ghataat::where('ID_G',$id_g_global)->get()->toArray();
                foreach($ghataats as $ghataat){
                    $n= Ansaldo_savabegh::where('ID_E',$ghataat['ID_E'])->where('ID_T',$id_t1)->get()->count();
                    if($n){
                        if($n>0){
                            return response()->json(['success'=>'hi','reapeted_no'=>$ghataat['ID_E'],'insert_type'=>2]);
                        }
                    }
                }
                foreach($ghataats as $ghataat){
                    $ghataat_count++;
                    DB::table('ansaldo_savabeghs')->insert([
                        'ID_E' => $ghataat['ID_E'],
                        'ID_T' => $id_t1,
                        'ID_SUB' => $id_sub,
                        'TIME_WORK' => $karkard,
                        'DAMAGE_PERCENT' => $mizan_kharabi,
                        'TYPE_INSTAL' => $vaz_nasb,
                        'DISCRIPTION' => $description,
                        'SAV_TYPE' => $type_sabegheh
                    ]);
                }
                return response()->json(['success'=>'hi','ghataat_count'=>$ghataat_count,'n'=>$id_g_global,'insert_type'=>2]);
            }
            if($insert_type==3){
                $ghataat_count=0;
                $ghataats= Ansaldo_ghataat::where('ID_G',$id_g_global)->orderBy('ID_E', 'DESC')->get()->toArray();
                foreach($ghataats as $ghataat){
                    $ghataat_count++;
                    if($ghataat_count>=$radif1 && $ghataat_count<=$radif2){
                        $n= Ansaldo_savabegh::where('ID_E',$ghataat['ID_E'])->where('ID_T',$id_t1)->get()->count();
                        if($n){
                            if($n>0){
                                return response()->json(['success'=>'hi','reapeted_no'=>$ghataat['ID_E'],'insert_type'=>2]);
                            }
                        }
                    }
                }
                $ghataat_count=0;
                
                foreach($ghataats as $ghataat){
                    $ghataat_count++;
                    if($ghataat_count>=$radif1 && $ghataat_count<=$radif2){
                        DB::table('ansaldo_savabeghs')->insert([
                            'ID_E' => $ghataat['ID_E'],
                            'ID_T' => $id_t1,
                            'ID_SUB' => $id_sub,
                            'TIME_WORK' => $karkard,
                            'DAMAGE_PERCENT' => $mizan_kharabi,
                            'TYPE_INSTAL' => $vaz_nasb,
                            'DISCRIPTION' => $description,
                            'SAV_TYPE' => $type_sabegheh
                        ]);
                    }


                }
                return response()->json(['success'=>'hi','ghataat_count'=>$radif2-$radif1+1,'n'=>$id_g_global,'insert_type'=>2]);
            }
        }
        // if($program==2000){
        //     if($insert_type==1){
        //         if($id_t_bazsazi2==0){
        //             $n= Ansaldo_savabegh::where('ID_E',$ghataat4)->where('ID_T',$id_t_bazsazi1)->get()->count();
        //             if($n){
        //                 if($n>0){
        //                     return response()->json(['success'=>'hi','reapeted_no'=>$ghataat4,'insert_type'=>1]);
        //                 }
        //             }
        //         }
        //         if($id_t_bazsazi2>0){
        //             $n= Ansaldo_savabegh::where('ID_E',$ghataat4)->where('ID_T',$id_t_bazsazi1)->get()->count();
        //             if($n){
        //                 if($n>0){
        //                     return response()->json(['success'=>'hi','reapeted_no'=>$ghataat4,'insert_type'=>1]);
        //                 }
        //             }
        //         }

        //         DB::table('ansaldo_savabeghs')->insert([
        //             'ID_E' => $ghataat4,
        //             'ID_T' => $id_t1,
        //             'ID_SUB' => $id_sub,
        //             'TIME_WORK' => $karkard,
        //             'DAMAGE_PERCENT' => $mizan_kharabi,
        //             'TYPE_INSTAL' => $vaz_nasb,
        //             'DISCRIPTION' => $description,
        //             'SAV_TYPE' => $type_sabegheh
        //         ]);

        //         return response()->json(['success'=>'hi','id_e'=>$ghataat4,'insert_type'=>1]);
        //     }
        //     if($insert_type==2){
        //         $ghataat_count=0;
        //         $ghataats= Ansaldo_ghataat::where('ID_G',$id_g_global)->get()->toArray();
        //         if($id_t_bazsazi2==0){
        //             foreach($ghataats as $ghataat){
        //                 $n= Ansaldo_savabegh::where('ID_E',$ghataat['ID_E'])->where('ID_T',$id_t_bazsazi1)->get()->count();
        //                 if($n){
        //                     if($n>0){
        //                         return response()->json(['success'=>'hi','reapeted_no'=>$ghataat['ID_E'],'insert_type'=>2]);
        //                     }
        //                 }
        //             }
        //         }
        //         if($id_t_bazsazi2>0){
        //             foreach($ghataats as $ghataat){
        //                 $n= Ansaldo_savabegh::where('ID_E',$ghataat['ID_E'])->where('ID_T',$id_t_bazsazi1)->get()->count();
        //                 if($n){
        //                     if($n>0){
        //                         return response()->json(['success'=>'hi','reapeted_no'=>$ghataat['ID_E'],'insert_type'=>2]);
        //                     }
        //                 }
        //             }
        //         }
        //         foreach($ghataats as $ghataat){
        //             $ghataat_count++;
        //             DB::table('ansaldo_savabeghs')->insert([
        //                 'ID_E' => $ghataat['ID_E'],
        //                 'ID_T' => $id_t1,
        //                 'ID_SUB' => $id_t_bazsazi2,
        //                 'TIME_WORK' => $karkard,
        //                 'DAMAGE_PERCENT' => $mizan_kharabi,
        //                 'TYPE_INSTAL' => $vaz_nasb,
        //                 'DISCRIPTION' => $description,
        //                 'SAV_TYPE' => $type_sabegheh
        //             ]);
        //         }
        //         return response()->json(['success'=>'hi','ghataat_count'=>$ghataat_count,'n'=>$id_g_global,'insert_type'=>2]);
        //     }
        //     if($insert_type==3){
        //         $ghataat_count=0;
        //         $ghataats= Ansaldo_ghataat::where('ID_G',$id_g_global)->get()->toArray();
        //         foreach($ghataats as $ghataat){
        //             $ghataat_count++;
        //             if($ghataat_count>=$radif1 && $ghataat_count<=$radif2){
        //                 $n= Ansaldo_savabegh::where('ID_E',$ghataat['ID_E'])->where('ID_T',$id_t1)->get()->count();
        //                 if($n){
        //                     if($n>0){
        //                         return response()->json(['success'=>'hi','reapeted_no'=>$ghataat['ID_E'],'insert_type'=>2]);
        //                     }
        //                 }
        //             }
        //         }
        //         $ghataat_count=0;
        //         foreach($ghataats as $ghataat){
        //             $ghataat_count++;
        //             if($ghataat_count>=$radif1 && $ghataat_count<=$radif2){
        //                 DB::table('ansaldo_savabeghs')->insert([
        //                     'ID_E' => $ghataat['ID_E'],
        //                     'ID_T' => $id_t1,
        //                     'ID_SUB' => $id_sub,
        //                     'TIME_WORK' => $karkard,
        //                     'DAMAGE_PERCENT' => $mizan_kharabi,
        //                     'TYPE_INSTAL' => $vaz_nasb,
        //                     'DISCRIPTION' => $description,
        //                     'SAV_TYPE' => $type_sabegheh
        //                 ]);
        //             }


        //         }
        //         $ghataat_count=$radif2-$radif1+1;
        //         return response()->json(['success'=>'hi','ghataat_count'=>$ghataat_count,'n'=>$id_g_global,'insert_type'=>2]);
        //     }
        // }

    }
    
    public function savabegh_update($sav_type,$mizan_kharabi,$vaz_nasb,$karkard,$description,$insert_type,$id_s,$id_g_global,$id_sub,$id_t1,$id_e,$id_t_prev,$radif1,$radif2){
        if($mizan_kharabi==1){
            $mizan_kharabi='سالم و تمیزکاری';
        }
        if($mizan_kharabi==2){
            $mizan_kharabi='سبک';
        }
        if($mizan_kharabi==3){
            $mizan_kharabi='متوسط';
        }
        if($mizan_kharabi==4){
            $mizan_kharabi='سنگین';
        }
        if($vaz_nasb==1){
            $vaz_nasb='مونتاژ';
        }
        if($vaz_nasb==2){
            $vaz_nasb='دمونتاژ';
        }
        if($vaz_nasb==3){
            $vaz_nasb='دمونتاژ و مونتاژ';
        }
        if($vaz_nasb==4){
            $vaz_nasb='بدون تغییر';
        }
        $ghataat_count=0;

        $ghataats= Ansaldo_ghataat::where('ID_G',$id_g_global)->orderBy('ID_E', 'DESC')->get()->toArray();


        if($insert_type==1){
            $affected = DB::table('ansaldo_savabeghs')->where('ID_S',$id_s)->update(array('TIME_WORK' => $karkard,'DAMAGE_PERCENT' => $mizan_kharabi,'TYPE_INSTAL' => $vaz_nasb,'DISCRIPTION'=>$description,'ID_T'=>$id_t1,'ID_SUB'=>$id_sub,'SAV_TYPE'=>$sav_type));
            return response()->json(['success'=>'hi']);
        }
        if($insert_type==2){
               foreach($ghataats as $ghataat){
                   $affected = DB::table('ansaldo_savabeghs')->where('ID_E',$ghataat['ID_E'])->where('ID_T',$id_t_prev)->update(array('TIME_WORK' => $karkard,'DAMAGE_PERCENT' => $mizan_kharabi,'TYPE_INSTAL' => $vaz_nasb,'DISCRIPTION'=>$description,'ID_T'=>$id_t1,'ID_SUB'=>$id_sub,'SAV_TYPE'=>$sav_type));
               }
               return response()->json(['success'=>'hi','g'=>$id_t1]);
        }
        if($insert_type==3){
                // foreach($ghataats as $ghataat){
                //     $n= Ansaldo_savabegh::where('ID_E',$ghataat['ID_E'])->where('ID_T',$id_t1)->get()->count();
                //     if($n){
                //         if($n>0){
                //             return response()->json(['success'=>'hi','reapeted_no'=>$ghataat['ID_E'],'insert_type'=>1]);
                //         }
                //     }
                // }
                $ghataat_count=0;
                foreach($ghataats as $ghataat){
                    $ghataat_count++;
                    if($ghataat_count>=$radif1 && $ghataat_count<=$radif2){
                        $affected = DB::table('ansaldo_savabeghs')->where('ID_E',$ghataat['ID_E'])->where('ID_T',$id_t_prev)->update(array('TIME_WORK' => $karkard,'DAMAGE_PERCENT' => $mizan_kharabi,'TYPE_INSTAL' => $vaz_nasb,'DISCRIPTION'=>$description,'ID_T'=>$id_t1,'ID_SUB'=>$id_sub,'SAV_TYPE'=>$sav_type));
                    }
                }
                return response()->json(['success'=>'hi','g'=>$radif1]);
        }
  


    }
    public function savabegh_delete($sav_type,$mizan_kharabi,$vaz_nasb,$karkard,$description,$id_t1,$id_sub,$id_g_global,$insert_type,$id_s,$id_t2,$id_t3,$ghataat4,$radif1,$radif2,$id_t_bazsazi1,$id_t_bazsazi2,$radif3){
        $ghataat_count=0;        
        if($insert_type==1){
            Ansaldo_savabegh::where('ID_S',$id_s)->delete();
            return response()->json(['success'=>'hi']);
            //return response()->json(['success'=>'hi','type_sabegheh'=>$sav_type,'mizan_kharabi'=>$mizan_kharabi,'vaz_nasb'=>$vaz_nasb,'karkard'=>$karkard,'description'=>$description,'id_t1'=>$id_t1,'id_t2'=>$id_t2,'id_g_global'=>$id_g_global,'id_sub'=>$id_sub,'insert_type'=>$insert_type,'id_s'=>$id_s,'sav_type'=>$sav_type,'id_t_bazsazi1'=>$id_t_bazsazi1,'id_t_bazsazi2'=>$id_t_bazsazi2,'ghataat'=>$ghataats]);
        }
        if($insert_type==2){
            Ansaldo_savabegh::where('ID_T',$id_t1)->delete();
            return response()->json(['success'=>'hi']);
           // return response()->json(['success'=>'hi','type_sabegheh'=>$sav_type,'mizan_kharabi'=>$mizan_kharabi,'vaz_nasb'=>$vaz_nasb,'karkard'=>$karkard,'description'=>$description,'id_t1'=>$id_t1,'id_t2'=>$id_t2,'id_g_global'=>$id_g_global,'id_sub'=>$id_sub,'insert_type'=>$insert_type,'id_s'=>$id_s,'sav_type'=>$sav_type,'id_t_bazsazi1'=>$id_t_bazsazi1,'id_t_bazsazi2'=>$id_t_bazsazi2,'ghataat'=>$ghataats,'n'=>$n]);
        }
        if($insert_type==3){
                $ghataat_count=0;
                $ghataats= Ansaldo_ghataat::where('ID_G',$id_g_global)->orderBy('ID_E', 'DESC')->get()->toArray();
                foreach($ghataats as $ghataat){
                    $ghataat_count++;
                    if($ghataat_count>=$radif1 && $ghataat_count<=$radif2){
                        Ansaldo_savabegh::where('ID_E',$ghataat['ID_E'])->where('ID_T',$id_t1)->delete();
                    }
                }
            return response()->json(['success'=>'hi','insert_type'=>$ghataats,'radif1'=>$radif1,'radif2'=>$radif2]);
        }

    }
    public function inserted_rows($id)
    {
        $tamir_prog = Ansaldo_tamirat_program::all();
        $id_tts = Ansaldo_tamirat_type::all();
        $id_tas = Ansaldo_tamirkaran::all();
        $id_un = Ansaldo_unit_number::all();
        $bazsazi1 = Ansaldo_send_bazsazi_ghataat::all();
        $bazsazi2 = Ansaldo_resv_bazsazi_ghataat::all();
        $anbar1 = Ansaldo_store_program_in::all();
        $anbar2 = Ansaldo_store_program_out::all();
        $kharid = Ansaldo_buy_ghataat::all();
        $data = DB::table('ansaldo_savabeghs')->where('ID_S','>',$id)->get()->toArray();
        return response()->json(['results'=> $data,'tamir_prog'=>$tamir_prog,'id_tts'=>$id_tts,'id_tas'=>$id_tas,'id_uns'=>$id_un]);
    }

}
