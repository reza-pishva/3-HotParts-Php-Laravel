<?php
namespace App\Http\Controllers;



use App\Ansaldo_group_name;
use App\Ansaldo_type_ghataat;
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


class AnsaldoGroupChangeController extends Controller
{
    /**
     * in this method we are going to save info from its form into 'ansaldo_group_names' table.
     * in addition,we get the id of current user,another values were gotten with $request argument.
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $atp= new Ansaldo_group_name();
        $atp->ID_TG=$request->input('ID_TG');
        $atp->GROUP_CODE=$request->input('GROUP_CODE');
        $atp->GROUP_TYPE=$request->input('GROUP_TYPE');
        $atp->ID_USER=$id_user;
        $atp->save();
        return response()->json(['message'=> 'this record was saved']);
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
                        if($role_name['role'] ==="admin" or $role_name['role'] ==="track_group_ghataat_change"){
                            $allow=1;
                            $g_y = Carbon::now()->year;
                            $g_m = Carbon::now()->month;
                            $g_d = Carbon::now()->day;
                            $Calendar=new CalendarHelper();
                            $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                            $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                            $mytime=Carbon::now();
                            $part = auth()->user()->id_request_part;
                            $requests = Ansaldo_group_name::all();
                            $ghataats =Ansaldo_type_ghataat::all();
                            $sazs = DB::table('ansaldo_sazandehs')->where('ID_S','>',0)->get()->toArray();
                            return view('Ansaldo.ansaldo_group_change',compact('requests','ghataats','sazs'));
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
        $data = DB::table('ansaldo_group_names')->where('ID_G','>',0)->orderBy('ID_G', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    public function total2($id)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_group_names')->where('ID_TG',$id)->orderBy('ID_G', 'DESC')->get()->toArray();
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
    public function onlyone()
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_G= Ansaldo_group_name::where('id_user',$id_user)->orderBy('ID_G', 'desc')->first()->ID_G;
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_group_names')->where('ID_G',$ID_G)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);
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
//        Ansaldo_group_name::where('ID_G', $id)->delete();
        $rec_no = DB::table('ansaldo_ghataats')->where('ID_G',$id)->get()->count();
        if($rec_no>0){
            return response()->json(['success'=>'hi','rec_no'=>1]);
        }else{
            Ansaldo_group_name::where('ID_G', $id)->delete();
            return response()->json(['success'=>'hi','rec_no'=>0]);
        }
    }
    public function edit(Request $request)
    {
        $ID_G_EDIT=$request->input('ID_G_EDIT');
        $ID_TG_EDIT=$request->input('ID_TG_EDIT');
        $GROUP_CODE_EDIT=$request->input('GROUP_CODE_EDIT');
        $GROUP_TYPE_EDIT=$request->input('GROUP_TYPE_EDIT');
        Ansaldo_group_name::where('ID_G', $ID_G_EDIT)->update([
            'ID_TG'=>$ID_TG_EDIT,
            'GROUP_CODE'=>$GROUP_CODE_EDIT,
            'GROUP_TYPE'=>$GROUP_TYPE_EDIT]);
        return response()->json(['success'=>'the information has successfuly saved','ID_G'=>$ID_G_EDIT]);
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function report_queryp(Request $request)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
//        $date_exit_shamsi1=$request->input('DATE_BEGINR');
//        $date_shamsi_array1 = explode('/',$date_exit_shamsi1);
//        $date_exit_shamsi2=$request->input('DATE_ENDR');
//        $date_shamsi_array2 = explode('/',$date_exit_shamsi2);
//        $date_exit_shamsi1=$date_shamsi_array1[0].$date_shamsi_array1[1].$date_shamsi_array1[2];
//        $date_exit_shamsi2=$date_shamsi_array2[0].$date_shamsi_array2[1].$date_shamsi_array2[2];
//        $date_exit_shamsi1=$this->convert($date_exit_shamsi1);
//        $date_exit_shamsi2=$this->convert($date_exit_shamsi2);

        $ID_TG_R=$request->input('ID_TG_R');
        $GROUP_TYPE_R=$request->input('GROUP_TYPE_R');

        if($ID_TG_R==0){
            $query1="$ID_TG_R>=0";
        }
        if($ID_TG_R!=0){
            $query1="ID_TG=".$ID_TG_R;
        }
        if($GROUP_TYPE_R==0){
            $query2="GROUP_TYPE>=0";
        }
        if($GROUP_TYPE_R!=0){
            $query2="GROUP_TYPE=".$GROUP_TYPE_R;
        }
        Querytext::where('id_user', $id_user)->delete();
        $query="SELECT * FROM ansaldo_group_names WHERE ".$query1." AND ".$query2."  ORDER BY ID_G DESC";//
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_TGS'=>$ID_TGS,'ID_USER'=>$id_user,'ID_USERS'=>$data3,'QUERY'=>$query]);
    }
//    public function report_queryp2()
//    {
//        $ID_UNS = DB::table('ansaldo_unit_numbers')->where('ID_UN','>',0)->get()->toArray();
//        $ID_TTS = DB::table('ansaldo_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
//        $ID_TAS = DB::table('ansaldo_tamirkarans')->where('ID_TA','>',0)->get()->toArray();
//        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
//        $id_user = auth()->user()->id;
//        $query = DB::table('querytexts')->where('ID_USER',$id_user)->orderBy('id_qu', 'DESC')->first()->query_text;
//        $requests = DB::select(DB::raw($query));
//        return response()->json(['results'=> $requests,'ID_UNS'=>$ID_UNS,'ID_TAS'=>$ID_TAS,'ID_TTS'=>$ID_TTS,'ID_USERS'=>$data3,'ID_USER'=>$id_user,'QUERY'=>$query]);
//    }

}
