<?php
namespace App\Http\Controllers;

use App\Ansaldo_bazsaz;
use App\Ansaldo_resv_bazsazi_ghataat;
use App\Ansaldo_savabegh;
use App\Ansaldo_send_bazsazi_ghataat;
use App\Ansaldo_tamirat_program;
use App\Ansaldo_tamirat_type;
use App\Ansaldo_tamirkaran;
use App\Ansaldo_type_ghataat;
use App\Ansaldo_unit_number;
use App\Querytext;
use App\CalendarHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Form;
use App\Goodstype;
use App\Grouprole;
use App\Groupuser;
use App\Request_level;
use App\Role;
use App\User_role;



class AnsaldoSendBazsaziGhataatController extends Controller
{
    /**
     * In this method we are going to save infoarmation into "ansaldo_send_bazsazi_ghataats" table.
     * this table is used to keep the properties of equipment sent to some places for reconstructure.
     * first we create an instance from the the class of its model.
     * then through request arguments we will retrieve values from its form located in our view and then we save it into "ansaldo_send_bazsazi_ghataats" table
     * then we send a message and the the id of the group which this part belongs to through a json file to our view.
    */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $atp= new Ansaldo_send_bazsazi_ghataat();
        $atp->ID_TG=$request->input('ID_TG');
        $atp->ID_BA=$request->input('ID_BA');
        $atp->GROUP_COUNT=$request->input('GROUP_COUNT');
        $atp->DISCRIPTION=$request->input('DISCRIPTION');
        $atp->SHOMAREH_GHARAR=$request->input('SHOMAREH_GHARAR');
        $atp->ID_USER=$id_user;
        $atp->EXIT_NO=0;
        $DATE_BEGIN1_array=explode('/',$request->input('DATE_BEGIN1'));
        $atp->DATE_BEGIN1=$this->convert($DATE_BEGIN1_array[0].$DATE_BEGIN1_array[1].$DATE_BEGIN1_array[2]);
        $atp->save();
        return response()->json(['message'=> 'it was saved']);
    }
    /**
     * In this method we authorize the person who wants to open the form which we can initialize equipment which we want to send outside for 
     * reconstructure in this software.
     * first we get the id , first name and last name of current user.then we retrieve the groups that our user belongs to.
     * then we get the roles of this user from different groups which this user belongs to after first foreach.
     * in the second foreach we get the name of roles of this user that has and if it was admin or 'track_create_program' 
     * we return the view of ansaldo_send_program and at the same time we pass the type of equipment and reconstructurerer companies to this view
     * if this user did not have acceptable roles to open this view we will return access_denied instead.
     */
    public function create()
    {
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
                 $requests = DB::table('ansaldo_send_bazsazi_ghataats')->where('ID_T','>',0)->orderBy('ID_T', 'DESC')->get()->toArray();
                 $ghataats =Ansaldo_type_ghataat::all();
                 $ats=Ansaldo_bazsaz::all();
                 return view('Ansaldo.ansaldo_send_program',compact('requests','ghataats','ats'));
               }
            }
          }
          if($allow===0){
             return view('access_denied');
          }

    }
   /**
     * In this method we we will get the whole rows from "ansaldo_send_bazsazi_ghataats" table.
     * this data is the list of equipment sent for reconstructure.
     * along with sending this data we need to send all types of equipment through json file to our view.
    */
    public function total()
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->get()->toArray();
        $data = DB::table('ansaldo_send_bazsazi_ghataats')->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS]);
    }
   /**
     * each user creates his/her own request for sending to the companies where this equipment is going to reconstructure
     * in this method we want to get all such requests created by our current user in the date that user has loged in.
     * along with this data we need to have types of all equipment and the id of our current user and recobstructor companies in the view.     
    */
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
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_send_bazsazi_ghataats')->where('ID_T','>',0)->where('ID_USER',$id_user)->where('DATE_BEGIN1','>=',$current_date_shamsi)->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS,'current_date_shamsi'=>$g_d]);//->where('DATE_BEGIN1',$current_date_shamsi)
    }
    public function onlyone()
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $ID_T=Ansaldo_send_bazsazi_ghataat::where('id_user',$id_user)->orderBy('ID_T', 'desc')->first()->ID_T;
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_send_bazsazi_ghataats')->where('ID_T',$ID_T)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS,'ID_USERS'=>$data3]);
    }
    public function onlyone2($id)
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_send_bazsazi_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    public function delete($id){
        $n= DB::table('ansaldo_savabeghs')->where('SAV_TYPE','B')->where('ID_T',$id)->get()->count();
        $rec_no = DB::table('ansaldo_resv_bazsazi_ghataats')->where('ID_T',$id)->get()->count();
        if($n==0){
            if($rec_no>0){
                return response()->json(['success'=>'hi','perm'=>0,'rec_no'=>$rec_no,'id_t'=>$id,'n'=>$n]);
            }else{
                Ansaldo_send_bazsazi_ghataat::where('ID_T', $id)->delete();
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
        $ID_BA_EDIT=$request->input('ID_BA_EDIT');
        $DISCRIPTION_EDIT=$request->input('DISCRIPTION_EDIT');
        $GROUP_COUNT_EDIT=$request->input('GROUP_COUNT_EDIT');
        $SHOMAREH_GHARAR_EDIT=$request->input('SHOMAREH_GHARAR_EDIT');
        $DATE_BEGIN_SH=$request->input('DATE_BEGIN1_EDIT');
        $DATE_BEGIN_SH_array=explode('/',$DATE_BEGIN_SH);
        $DATE_BEGIN1_EDIT=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);
        Ansaldo_send_bazsazi_ghataat::where('ID_T', $ID_T_EDIT)->update([
                'ID_TG'=>$ID_TG_EDIT,
                'ID_BA'=>$ID_BA_EDIT,
                'GROUP_COUNT'=>$GROUP_COUNT_EDIT,
                'SHOMAREH_GHARAR'=>$SHOMAREH_GHARAR_EDIT,
                'DISCRIPTION'=>$DISCRIPTION_EDIT,
                'DATE_BEGIN1'=>$DATE_BEGIN1_EDIT]);
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
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
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
        $ID_BA_R=$request->input('ID_BA_R');
        $ID_TG_R=$request->input('ID_TG_R');
        $RESV_R=$request->input('RESV_R');

        if($ID_BA_R==0){
            $query1="ID_BA>0";
        }
        if($ID_TG_R==0){
            $query2="ID_TG>0";
        }
        if($RESV_R==0){
            $query3="RESV>0";
        }
        if($ID_BA_R!=0){
            $query1="ID_BA=".$ID_BA_R;
        }
        if($ID_TG_R!=0){
            $query2="ID_TG=".$ID_TG_R;
        }

//        $query4="DATE_BEGIN1>=".$date_exit_shamsi1;
//        $query5="DATE_BEGIN1<=".$date_exit_shamsi2;


        Querytext::where('id_user', $id_user)->delete();
        if($RESV_R==0){
            $query="SELECT * FROM bazsazi_view WHERE ".$query1." AND ".$query2." GROUP BY ID_T ORDER BY ID_T DESC";
        }
        if($RESV_R==1){
            $query="SELECT * FROM bazsazi_view WHERE ".$query1." AND ".$query2." AND COUNT_GH=GROUP_COUNT GROUP BY ID_T ORDER BY ID_T DESC";
        }
        if($RESV_R==2){
            $query="SELECT * FROM bazsazi_view WHERE ".$query1." AND ".$query2." AND COUNT_GH != GROUP_COUNT GROUP BY ID_T ORDER BY ID_T DESC";
        }

        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_BAS'=>$ID_BAS,'ID_TGS'=>$ID_TGS,'ID_TTS'=>$RESV_R,'ID_USER'=>$id_user,'ID_USERS'=>$data3,'QUERY'=>$query]);
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
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
//        $ID_UNS = DB::table('ansaldo_unit_numbers')->where('ID_UN','>',0)->get()->toArray();
//        $ID_TTS = DB::table('ansaldo_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
//        $ID_TAS = DB::table('ansaldo_tamirkarans')->where('ID_TA','>',0)->get()->toArray();
//        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_send_bazsazi_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS]);//,'ID_USERS'=>$ID_USERS
    }
    public function report_queryp4($id)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
//        $ID_UNS = DB::table('ansaldo_unit_numbers')->where('ID_UN','>',0)->get()->toArray();
//        $ID_TTS = DB::table('ansaldo_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
//        $ID_TAS = DB::table('ansaldo_tamirkarans')->where('ID_TA','>',0)->get()->toArray();
//        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_resv_bazsazi_ghataats')->where('ID_SUB',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS]);//,'ID_USERS'=>$ID_USERS
    }


}
