<?php
namespace App\Http\Controllers;



use App\Mitsubishi_send_bazsazi_ghataat;
use App\Mitsubishi_store_program_in;
use App\Mitsubishi_type_ghataat;
use App\Querytext;
use App\User;
use App\CalendarHelper;
use Carbon\Carbon;
use App\Form;
use App\Goodstype;
use App\Grouprole;
use App\Groupuser;
use App\Request_level;
use App\Role;
use App\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MitsubishiStoreProgramInController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $atp= new Mitsubishi_store_program_in();
        $atp->ID_TG=$request->input('ID_TG');
        $atp->ID_NN=$request->input('ID_BA');
        $atp->GROUP_COUNT=$request->input('GROUP_COUNT');
        $atp->DISCRIPTION=$request->input('DISCRIPTION');
        $atp->GHATAAT_DAMAGE=$request->input('GHATAAT_DAMAGE');
        $atp->ID_USER=$id_user;
        $atp->EXIT_NO=0;
        $DATE_BEGIN1_array=explode('/',$request->input('DATE_SHAMSI'));
        $atp->DATE_SHAMSI=$this->convert($DATE_BEGIN1_array[0].$DATE_BEGIN1_array[1].$DATE_BEGIN1_array[2]);
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
                                                        if($role_name['role'] ==="admin" or $role_name['role'] ==="track_create_program"){
                                                            $allow=1;
                                                            $g_y = Carbon::now()->year;
                                                            $g_m = Carbon::now()->month;
                                                            $g_d = Carbon::now()->day;
                                                            $Calendar=new CalendarHelper();
                                                            $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                                                            $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                                                            $mytime=Carbon::now();
                                                            $part = auth()->user()->id_request_part;
                                                            $requests = DB::table('mitsubishi_store_program_ins')->where('ID_T','>',0)->orderBy('ID_T', 'DESC')->get()->toArray();
                                                            $ghataats =Mitsubishi_type_ghataat::all();
                                                            return view('Mitsubishi.mitsubishi_store_program_ins',compact('requests','ghataats'));
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
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
//        $ID_BAS = DB::table('mitsubishi_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_store_program_ins')->where('ID_T','>',0)->orderBy('ID_T', 'DESC')->get()->toArray();
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
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
//        $ID_BAS = DB::table('mitsubishi_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_store_program_ins')->where('ID_T','>',0)->where('ID_USER',$id_user)->where('DATE_SHAMSI','>=',$current_date_shamsi)->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3,'current_date_shamsi'=>$g_d]);//->where('DATE_BEGIN1',$current_date_shamsi)
    }
    public function onlyone()
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_T=Mitsubishi_store_program_in::where('id_user',$id_user)->orderBy('ID_T', 'desc')->first()->ID_T;
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_store_program_ins')->where('ID_T',$ID_T)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);
    }
    public function onlyone2($id)
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_store_program_ins')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    public function delete($id){
        $n= DB::table('mitsubishi_savabeghs')->where('SAV_TYPE','A')->where('ID_T',$id)->get()->count();
        $rec_no = DB::table('mitsubishi_store_program_outs')->where('ID_T',$id)->get()->count();
        if($n==0){
            if($rec_no>0){
                return response()->json(['success'=>'hi','perm'=>0,'rec_no'=>$rec_no,'id_t'=>$id,'n'=>$n]);
            }else{
                Mitsubishi_store_program_in::where('ID_T', $id)->delete();
                return response()->json(['success'=>'hi','perm'=>0,'rec_no'=>$rec_no,'id_t'=>$id,'n'=>$n]);
            }
        }else{
            return response()->json(['success'=>'hi','perm'=>0,'rec_no'=>$rec_no,'id_t'=>$id,'n'=>$n]);
        }
    }
    public function edit(Request $request)
    {
        $ID_T_EDIT=$request->input('ID_T_EDIT');
        $ID_TG_EDIT=$request->input('ID_TG_EDIT');
        $DISCRIPTION_EDIT=$request->input('DISCRIPTION_EDIT');
        $GROUP_COUNT_EDIT=$request->input('GROUP_COUNT_EDIT');
        $GHATAAT_DAMAGE_EDIT=$request->input('GHATAAT_DAMAGE_EDIT');
        $DATE_SHAMSI_EDIT=$request->input('DATE_SHAMSI_EDIT');
        $DATE_BEGIN_SH_array=explode('/',$DATE_SHAMSI_EDIT);
        $DATE_SHAMSI_EDIT=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);
        Mitsubishi_store_program_in::where('ID_T', $ID_T_EDIT)->update([
            'ID_TG'=>$ID_TG_EDIT,
            'GROUP_COUNT'=>$GROUP_COUNT_EDIT,
            'GHATAAT_DAMAGE'=>$GHATAAT_DAMAGE_EDIT,
            'DISCRIPTION'=>$DISCRIPTION_EDIT,
            'DATE_SHAMSI'=>$DATE_SHAMSI_EDIT]);
        return response()->json(['success'=>'the information has successfuly saved','ID_T'=>$ID_T_EDIT]);
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function report_queryp(Request $request)
    {
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
        $GHATAAT_DAMAGE_R=$request->input('GHATAAT_DAMAGE_R');
        $ID_TG_R=$request->input('ID_TG_R');
        $RESV_R=$request->input('RESV_R');

        if($RESV_R==0){
            $query3="ID_T>0";
        }
        if($RESV_R==1){
            $query3="ID_T>0";
        }
        if($RESV_R==2){
            $query3="(EXIT_NO < GROUP_COUNT OR EXIT_NO = 0)";
        }
        if($RESV_R==3){
            $query3="EXIT_NO = GROUP_COUNT";
        }
        if($ID_TG_R==0){
            $query2="ID_TG>0";
        }
        if($ID_TG_R!=0){
            $query2="ID_TG=".$ID_TG_R;
        }
        if($GHATAAT_DAMAGE_R==0){
            $query6="ID_T>0";
        }
        if($GHATAAT_DAMAGE_R==1){
            $query6="GHATAAT_DAMAGE='نو'";
        }
        if($GHATAAT_DAMAGE_R==2){
            $query6="GHATAAT_DAMAGE='قابل بازسازی'";
        }
        if($GHATAAT_DAMAGE_R==3){
            $query6="GHATAAT_DAMAGE='بازسازی شده'";
        }
        if($GHATAAT_DAMAGE_R==4){
            $query6="GHATAAT_DAMAGE='ریجکت'";
        }




        Querytext::where('id_user', $id_user)->delete();
        $query="SELECT * FROM mitsubishi_store_program_ins WHERE ".$query2." AND ".$query3." AND ".$query6." ORDER BY ID_T DESC";
        //$query="SELECT * FROM mitsubishi_store_program_ins WHERE ORDER BY ID_T DESC";
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_TGS'=>$ID_TGS,'ID_USER'=>$id_user,'ID_USERS'=>$data3,'QUERY'=>$query]);
    }
    public function report_queryp2()
    {
        $ID_UNS = DB::table('mitsubishi_unit_numbers')->where('ID_UN','>',0)->get()->toArray();
        $ID_TTS = DB::table('mitsubishi_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
        $ID_TAS = DB::table('mitsubishi_tamirkarans')->where('ID_TA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
        $query = DB::table('querytexts')->where('ID_USER',$id_user)->orderBy('id_qu', 'DESC')->first()->query_text;
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_UNS'=>$ID_UNS,'ID_TAS'=>$ID_TAS,'ID_TTS'=>$ID_TTS,'ID_USERS'=>$data3,'ID_USER'=>$id_user,'QUERY'=>$query]);
    }
    public function report_queryp3(Request $request)
    {
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
        $ID_TG_R=$request->input('ID_TG_R');
        $RESV_R=$request->input('RESV_R');
        $GHATAAT_DAMAGE_R=$request->input('GHATAAT_DAMAGE_R');
        if($ID_TG_R==0){
            $query2="ID_TG>0";
        }
        if($ID_TG_R!=0){
            $query2="ID_TG=".$ID_TG_R;
        }
        if($GHATAAT_DAMAGE_R ==0){
            $query3="ID_TG>0";
        }
        if($GHATAAT_DAMAGE_R ==1){
            $query3="GHATAAT_DAMAGE ='نو'";
        }
        if($GHATAAT_DAMAGE_R ==2){
            $query3="GHATAAT_DAMAGE ='قابل بازسازی'";
        }
        if($GHATAAT_DAMAGE_R ==3){
            $query3="GHATAAT_DAMAGE ='بازسازی شده'";
        }
        if($GHATAAT_DAMAGE_R ==4){
            $query3="GHATAAT_DAMAGE ='ریجکت'";
        }
        Querytext::where('id_user', $id_user)->delete();
        if($RESV_R==0){
            $query="SELECT * FROM mitsubishi_anbar_send_recieve_view WHERE ".$query2." AND ".$query3."  ORDER BY ID_T DESC";
        }
        if($RESV_R==1){
            $query="SELECT * FROM mitsubishi_anbar_send_recieve_view WHERE ".$query2." AND ".$query3."  AND COUNT_GH = GROUP_COUNT ORDER BY ID_T DESC";
        }
        if($RESV_R==2){
            $query="SELECT * FROM mitsubishi_anbar_send_recieve_view WHERE ".$query2." AND ".$query3." AND COUNT_GH != GROUP_COUNT ORDER BY ID_T DESC";
        }
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_TGS'=>$ID_TGS,'ID_USER'=>$id_user,'ID_USERS'=>$data3,'QUERY'=>$query]);
    }
    public function report_queryp4($id)
    {
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_store_program_ins')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS]);//,'ID_USERS'=>$ID_USERS
    }
    public function report_queryp5($id)
    {
        $data = DB::table('mitsubishi_store_program_outs')->where('ID_SUB',$id)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
}