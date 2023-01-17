<?php
namespace App\Http\Controllers;
use App\Groupuser;
use App\Ansaldo_bazsaz;
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
use App\Ansaldo_unit_number;
use App\Mitsubishi_out_ghataat;
use App\Querytext;
use App\CalendarHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Form;
use App\Goodstype;
use App\Grouprole;
use App\Request_level;
use App\Role;
use App\User_role;
use Morilog\Jalali\Jalalian;


class AnsaldoTamiratProgramController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $validation = Validator::make($request->all(), [
            'select_file' => 'mimes:jpeg,bmp,png,gif,svg,pdf,pptx,xls,xlsx,docx,csv,rar,zip|max:10240'
        ]);
        $id_t=0;


        $id_user=auth()->user()->id;
        $atp= new Ansaldo_tamirat_program();
        $atp->ID_UN=$request->input('ID_UN');
        $atp->ID_NN=$request->input('ID_NN');
        $atp->ID_USER=$id_user;
        $atp->ID_TT=$request->input('ID_TT');
        $atp->ID_TA=$request->input('ID_TA');
        $atp->TIME_WORK_REAL=$request->input('TIME_WORK_REAL');
        $atp->TIME_WORK_EQUAL=$request->input('TIME_WORK_EQUAL');
        if($request->input('ANGAM')==1){
            $atp->ANGAM =1;
        }else{
            $atp->ANGAM =2;
        }
        if($request->input('CONFIR')==1){
            $atp->CONFIR =1;
        }else{
            $atp->CONFIR =2;
        }
        $atp->DISCRIPTION=$request->input('DISCRIPTION');
        $atp->DATE_BEGIN_SH=$request->input('DATE_BEGIN_SH');
        $DATE_BEGIN_SH_array=explode('/',$atp->DATE_BEGIN_SH);
        $atp->DATE_BEGIN_SH=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);
        $atp->DATE_END_SH=$request->input('DATE_END_SH');
        $DATE_END_SH_array=explode('/',$atp->DATE_END_SH);
        $atp->DATE_END_SH=$this->convert($DATE_END_SH_array[0].$DATE_END_SH_array[1].$DATE_END_SH_array[2]);
        if($request->file('select_file')){
            if($validation->failed()==false)
            {
                if (DB::table('ansaldo_tamirat_programs')->where('ID_T','>',0)->exists()){
                    $id_t = (DB::table('ansaldo_tamirat_programs')->where('ID_T','>',0)->orderBy('ID_T', 'DESC')->first()->ID_T)+1;
                }
                else{
                    $id_t = 1;
                }

                $image = $request->file('select_file');
                $new_name = (string) $id_t. '.' . $image->getClientOriginalExtension();
                $exten=$image->getClientOriginalExtension();
                $image->move(public_path('images'), $new_name);
                $atp->FILE_NAME=(string) $id_t.'.'.$exten;
            }
        }
        else{
            $atp->FILE_NAME='فایل پیوست ندارد';
        }

        $atp->save();
        return response()->json([
            'message'   => $request->file('select_file')
//            'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
//           'class_name'  => 'alert-success'
        ]);
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
                                                            $requests=Ansaldo_tamirat_program::all();
                                                            $anns=Ansaldo_nirogah_name::all();
                                                            $auns=Ansaldo_unit_number::all();
                                                            $atts=Ansaldo_tamirat_type::all();
                                                            $ats=Ansaldo_tamirkaran::all();
                                                    
                                                            return view('Ansaldo.ansaldo_tamirat_program',compact('requests','anns','auns','atts','ats'));
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
        $ID_UNS = DB::table('ansaldo_unit_numbers')->where('ID_UN','>',0)->get()->toArray();
        $ID_TTS = DB::table('ansaldo_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
        $ID_TAS = DB::table('ansaldo_tamirkarans')->where('ID_TA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_tamirat_programs')->where('ID_T','>',0)->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_UNS'=>$ID_UNS,'ID_TAS'=>$ID_TAS,'ID_TTS'=>$ID_TTS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    public function delete($id){
        $id_user=auth()->user()->id;
        $n= Ansaldo_savabegh::where('ID_T', $id)->where('SAV_TYPE','T')->get()->count();
        if($n==0){
            $id_t = DB::table('ansaldo_tamirat_programs')->where('ID_USER',$id_user)->orderBy('ID_T', 'DESC')->first()->ID_T;
            Ansaldo_tamirat_program::where('ID_T', $id)->delete();
            return response()->json(['success'=>'hi','id_t'=>$id_t,'perm'=>1]);
        }else{
            return response()->json(['success'=>'hi','perm'=>0]);
        }
    }
    public function edit(Request $request)
    {
        $ID_T=$request->input('ID_T_EDIT');
        $FILE_NAME_EDIT=DB::table('ansaldo_tamirat_programs')->where('ID_T',$ID_T)->orderBy('ID_T', 'DESC')->first()->FILE_NAME;
        $validation = Validator::make($request->all(), [
            'select_file_edit' => 'mimes:jpeg,bmp,png,gif,svg,pdf,pptx,xls,xlsx,docx,csv,rar,zip|max:10240'
        ]);
        $ID_UN=$request->input('ID_UN_EDIT');
        $ID_TT=$request->input('ID_TT_EDIT');
        $ID_TA=$request->input('ID_TA_EDIT');
        $TIME_WORK_REAL=$request->input('TIME_WORK_REAL_EDIT');
        $TIME_WORK_EQUAL=$request->input('TIME_WORK_EQUAL_EDIT');
        $DISCRIPTION=$request->input('DISCRIPTION_EDIT');
        $DATE_BEGIN_SH=$request->input('DATE_BEGIN_SH_EDIT');
        $DATE_BEGIN_SH_array=explode('/',$DATE_BEGIN_SH);
        $DATE_BEGIN=$DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2];
        $DATE_END=$request->input('DATE_END_SH_EDIT');
        $DATE_END_SH_array=explode('/',$DATE_END);
        $DATE_END=$DATE_END_SH_array[0].$DATE_END_SH_array[1].$DATE_END_SH_array[2];
        if($request->input('ANGAM_EDIT')==1){
            $ANGAM =1;
        }else{
            $ANGAM =2;
        }
        if($request->input('CONFIR_EDIT')==1){
            $CONFIR =1;
        }else{
            $CONFIR =2;
        }
        if($request->file('select_file_edit')){

            $image = $request->file('select_file_edit');
            $new_name = (string) $ID_T. '.' . $image->getClientOriginalExtension();
            $exten=$image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            $FILE_NAME_EDIT=(string) $ID_T.'.'.$exten;

            Ansaldo_tamirat_program::where('ID_T', $ID_T)->update([
                'FILE_NAME'=>$FILE_NAME_EDIT,
                'ID_UN'=>$ID_UN,
                'ID_TT'=>$ID_TT,
                'ID_TA'=>$ID_TA,
                'TIME_WORK_REAL'=>$TIME_WORK_REAL,
                'TIME_WORK_EQUAL'=>$TIME_WORK_EQUAL,
                'DATE_BEGIN_SH'=>$this->convert($DATE_BEGIN),
                'DATE_END_SH'=>$this->convert($DATE_END),
                'DISCRIPTION'=>$DISCRIPTION,
                'ANGAM'=>$ANGAM,
                'CONFIR'=>$CONFIR]);
        }else{
            Ansaldo_tamirat_program::where('ID_T', $ID_T)->update([
                'FILE_NAME'=>$FILE_NAME_EDIT,
                'ID_UN'=>$ID_UN,
                'ID_TT'=>$ID_TT,
                'ID_TA'=>$ID_TA,
                'TIME_WORK_REAL'=>$TIME_WORK_REAL,
                'TIME_WORK_EQUAL'=>$TIME_WORK_EQUAL,
                'DATE_BEGIN_SH'=>$this->convert($DATE_BEGIN),
                'DATE_END_SH'=>$this->convert($DATE_END),
                'DISCRIPTION'=>$DISCRIPTION,
                'ANGAM'=>$ANGAM,
                'CONFIR'=>$CONFIR]);
        }
        return response()->json(['success'=>'the information has successfuly saved','FILE'=>$FILE_NAME_EDIT]);
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function report_queryp(Request $request)
    {
        $ID_UNS = DB::table('ansaldo_unit_numbers')->where('ID_UN','>',0)->get()->toArray();
        $ID_TTS = DB::table('ansaldo_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
        $ID_TAS = DB::table('ansaldo_tamirkarans')->where('ID_TA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();

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


        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
//        $date_exit_shamsi1=$request->input('DATE_BEGIN_SH_REP');
//        $date_shamsi_array1 = explode('/',$date_exit_shamsi1);
//        $date_exit_shamsi2=$request->input('DATE_END_SH_REP');
//        $date_shamsi_array2 = explode('/',$date_exit_shamsi2);
//        $date_exit_shamsi1=$date_shamsi_array1[0].$date_shamsi_array1[1].$date_shamsi_array1[2];
//        $date_exit_shamsi2=$date_shamsi_array2[0].$date_shamsi_array2[1].$date_shamsi_array2[2];
//        $date_exit_shamsi1=$this->convert($date_exit_shamsi1);
//        $date_exit_shamsi2=$this->convert($date_exit_shamsi2);
        $ID_UN_REP=$request->input('ID_UN_REP');
        $ID_TT_REP=$request->input('ID_TT_REP');
        $ID_TA_REP=$request->input('ID_TA_REP');
        $ANGAM_REP=$request->input('ANGAM_REP');
        $CONFIR_REP=$request->input('CONFIR_REP');
        if($ID_UN_REP==0){
            $query1="ID_T>0";
        }
        if($ID_TT_REP==0){
            $query2="ID_T>0";
        }
        if($ID_TA_REP==0){
            $query3="ID_T>0";
        }
        if($ANGAM_REP==0){
            $query6="ID_T>0";
        }
        if($CONFIR_REP==0){
            $query7="ID_T>0";
        }
        if($ID_UN_REP!=0){
            $query1="ID_UN=".$ID_UN_REP;
        }
        if($ID_TT_REP!=0){
            $query2="ID_TT=".$ID_TT_REP;
        }
        if($ID_TA_REP!=0){
            $query3="ID_TA=".$ID_TA_REP;
        }
        if($ANGAM_REP!=0){
            $query6="ANGAM=".$ANGAM_REP;
        }
        if($CONFIR_REP!=0){
            $query7="CONFIR=".$CONFIR_REP;
        }
//        $query4="DATE_BEGIN_SH>=".$date_exit_shamsi1;
//        $query5="DATE_BEGIN_SH<=".$date_exit_shamsi2;


        Querytext::where('id_user', $id_user)->delete();
        $query="SELECT * FROM ansaldo_tamirat_programs WHERE ".$query1." AND ".$query2." AND ".$query3." AND ".$query6." AND ".$query7." ORDER BY ID_T DESC";
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
//        $forms = DB::table('ansaldo_tamirat_programs')->where('ID_T','>',0)->get()->toArray();
        return response()->json(['results'=> $requests,'ID_UNS'=>$ID_UNS,'ID_TAS'=>$ID_TAS,'ID_TTS'=>$ID_TTS,'ID_USERS'=>$data3,'CONFIR'=>$CONFIR_REP,'ANGAM'=>$ANGAM_REP,'ID_USER'=>$id_user,'QUERY'=>$query]);
    }
    public function report_queryp2()
    {
        $ID_UNS = DB::table('ansaldo_unit_numbers')->where('ID_UN','>',0)->get()->toArray();
        $ID_TTS = DB::table('ansaldo_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
        $ID_TAS = DB::table('ansaldo_tamirkarans')->where('ID_TA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
        $query = DB::table('querytexts')->where('ID_USER',$id_user)->orderBy('id_qu', 'DESC')->first()->query_text;
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_UNS'=>$ID_UNS,'ID_TAS'=>$ID_TAS,'ID_TTS'=>$ID_TTS,'ID_USERS'=>$data3,'ID_USER'=>$id_user,'QUERY'=>$query]);
    }
    public function report_queryp3($id)
    {
        $ID_UNS = DB::table('ansaldo_unit_numbers')->where('ID_UN','>',0)->get()->toArray();
        $ID_TTS = DB::table('ansaldo_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
        $ID_TAS = DB::table('ansaldo_tamirkarans')->where('ID_TA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_tamirat_programs')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_UNS'=>$ID_UNS,'ID_TAS'=>$ID_TAS,'ID_TTS'=>$ID_TTS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    public function convert_to_jalali()
    {
//
        $Calendar=new CalendarHelper();
//        $myArray =[];
//        $year=substr('2004-10-10',0,4);
//        $month=substr('2004-10-10',5,2);
//        $day=substr('2004-10-10',8,2);
//        $jDate=\Morilog\Jalali\CalendarUtils::toJalali($year, $month, $day);

        $requests=Mitsubishi_out_ghataat::all();
        foreach($requests as $request):
            //$reza=$request->DATE_BEGIN;
            $year=substr((string)$request->DATE_BEGIN,0,4);
            $month=substr((string)$request->DATE_BEGIN,5,2);
            $day=substr((string)$request->DATE_BEGIN,8,2);
            $jDate=$Calendar->gregorian_to_jalali((int)$year, (int)$month, (int)$day);
            if($jDate[2]<10){
                $myArray[0]=0;
                $myArray[1]=$jDate[1];
                $day=implode("",$myArray);
                $jDate[2]=$day;
            }
            if($jDate[1]<10){
                $myArray[0]=0;
                $myArray[1]=$jDate[1];
                $month=implode("",$myArray);
                $jDate[1]=$month;
            }
            $date_shamsi=implode("",$jDate);
            Mitsubishi_out_ghataat::where('ID_T',$request->ID_T)->update(['DATE_SHAMSI'=>$date_shamsi]);
//            $year=substr((string)$request->DATE_END,0,4);
//            $month=substr((string)$request->DATE_END,5,2);
//            $day=substr((string)$request->DATE_END,8,2);
//            $jDate=$Calendar->gregorian_to_jalali((int)$year, (int)$month, (int)$day);
//            if($jDate[2]<10){
//                $myArray[0]=0;
//                $myArray[1]=$jDate[1];
//                $day=implode("",$myArray);
//                $jDate[2]=$day;
//            }
//            if($jDate[1]<10){
//                $myArray[0]=0;
//                $myArray[1]=$jDate[1];
//                $month=implode("",$myArray);
//                $jDate[1]=$month;
//            }
//            $date_shamsi=implode("",$jDate);
//            Ansaldo_tamirat_program::where('ID_T',$request->ID_T)->update(['DATE_END_SH'=>$date_shamsi]);
        endforeach;

        //$date_miladi_array=$Calendar->gregorian_to_jalali($year, $month, $day);
//        $date_shamsi=implode("",$jDate);
        //Ansaldo_tamirat_program::where('ID_T',1)->update(['DATE_BEGIN_SH'=>(int)$date_shamsi]);
        return response()->json(['results'=>$jDate]);
    }
    public function get_history($id)
    {
        $data = DB::table('savabegh_total_view')->where('ID_T',$id)->where('SAV_TYPE','T')->get()->toArray();
        return response()->json(['results'=> $data]);

    }
}