<?php
namespace App\Http\Controllers;



use App\Ansaldo_bazsaz;
use App\Ansaldo_out_ghataat;
use App\Ansaldo_savabegh;
use App\Ansaldo_type_ghataat;
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


class AnsaldoOutGhataatController extends Controller
{
    /**
     * In this method we are going to save infoarmation into "ansaldo_ghataats" table.
     * this table is used to keep the properties of equipment used in hot parts of power plant.
     * first we create an instance from the the class of its model.
     * then through request arguments we will retrieve values from its form located in our view and then we save it into "ansaldo_ghataats" table
     * then we send a message and the the id of the group which this part belongs to through a json file to our view.
    */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $atp= new Ansaldo_out_ghataat();
        $atp->ID_TG=$request->input('ID_TG');
        $atp->GROUP_COUNT=$request->input('GROUP_COUNT');
        $atp->DISCRIPTION=$request->input('DISCRIPTION');
        $atp->OUT_IN=$request->input('OUT_IN');
        $atp->LOCATION_NAME=$request->input('LOCATION_NAME');
        $DATE_BEGIN1_array=explode('/',$request->input('DATE_SHAMSI'));
        $atp->DATE_SHAMSI=$this->convert($DATE_BEGIN1_array[0].$DATE_BEGIN1_array[1].$DATE_BEGIN1_array[2]);
        $atp->ID_USER=$id_user;
        $atp->save();
        return response()->json(['message'=> 'hi']);
    }
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
                 $requests = DB::table('ansaldo_store_program_ins')->where('ID_T','>',0)->orderBy('ID_T', 'DESC')->get()->toArray();
                 $ghataats =Ansaldo_type_ghataat::all();
                 $ats=Ansaldo_bazsaz::all();
                 return view('Ansaldo.ansaldo_out_program',compact('requests','ghataats','ats'));
               }
             }
          }
          if($allow===0){
          return view('access_denied');
        }
    }
    /**
     * In this method we we will get the whole rows from "ansaldo_ghataats" table.
     * along with sending this data we need to send all types of equipment through json file to our view.
    */
    public function total()
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_out_ghataats')->where('ID_T','>',0)->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    /**
     * each user creates his/her own group and then insert many equpment info into this group.
     * in this method we want to get the name of groups created by our current user in the date that user has loged in.
     * along with this data we need to have types of all equipment and the id of our current user in the view.     
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
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_out_ghataats')->where('ID_T','>',0)->where('ID_USER',$id_user)->where('DATE_SHAMSI','>=',$current_date_shamsi)->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3,'current_date_shamsi'=>$g_d]);//->where('DATE_BEGIN1',$current_date_shamsi)
    }
    public function onlyone()
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $ID_T=Ansaldo_out_ghataat::where('id_user',$id_user)->orderBy('ID_T', 'desc')->first()->ID_T;
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_out_ghataats')->where('ID_T',$ID_T)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3,'ID_BAS'=>$ID_BAS]);
    }
    /**
     * in this method we want to get the name of a group with specific id.
     * along with this row we need to have types of all equipment in the view.     
    */
    public function onlyone2($id)
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('ansaldo_out_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    /**
     * in this method we are going to remove a row from "ansaldo_ghataats" table.
     * before removing the row ,we will check if there is any row with this id in the history of that equipment.     
    */
    public function delete($id){
        $n= Ansaldo_savabegh::where('ID_T', $id)->where('SAV_TYPE','O')->get()->count();
        if($n==0){
            Ansaldo_out_ghataat::where('ID_T', $id)->delete();
            return response()->json(['success'=>'hi','id_t'=>$id,'perm'=>1]);
        }else{
            return response()->json(['success'=>'hi','perm'=>0]);
        }
    }
    /**
     * in this method we are going to edit a row from "ansaldo_ghataats" table.
     * before updating the row ,we check if there is any row with the same serial number exists in that table.  
     * if there was,user can not edit that row.  
    */
    public function edit(Request $request)
    {
        $ID_T_EDIT=$request->input('ID_T_EDIT');
        $ID_TG_EDIT=$request->input('ID_TG_EDIT');
        $DISCRIPTION_EDIT=$request->input('DISCRIPTION_EDIT');
        $GROUP_COUNT_EDIT=$request->input('GROUP_COUNT_EDIT');
        $LOCATION_NAME_EDIT=$request->input('LOCATION_NAME_EDIT');
        $OUT_IN_EDIT=$request->input('OUT_IN_EDIT');
        $DATE_SHAMSI_EDIT=$request->input('DATE_SHAMSI_EDIT');
        $DATE_BEGIN_SH_array=explode('/',$DATE_SHAMSI_EDIT);
        $DATE_SHAMSI_EDIT=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);

        Ansaldo_out_ghataat::where('ID_T', $ID_T_EDIT)->update([
            'ID_TG'=>$ID_TG_EDIT,
            'GROUP_COUNT'=>$GROUP_COUNT_EDIT,
            'DISCRIPTION'=>$DISCRIPTION_EDIT,
            'OUT_IN'=>$OUT_IN_EDIT,
            'LOCATION_NAME'=>$LOCATION_NAME_EDIT,
            'DATE_SHAMSI'=>$DATE_SHAMSI_EDIT]);
        return response()->json(['success'=>'the information has successfuly saved','ID_T'=>$ID_T_EDIT]);
    }
   /**
     * In this method we are going to convert latin numbers into persian numbers.
    */
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

        $ID_TG_R=$request->input('ID_TG_R');
//        $OUT_IN_R=$request->input('OUT_IN_R');
//        $RESV_R=$request->input('RESV_R');
//
//        if($RESV_R==0){
//            $query3="EXIT_NO>=0";
//        }
//        if($RESV_R==1){
//            $query3="EXIT_NO=0";
//        }
//        if($RESV_R==2){
//            $query3="EXIT_NO != GROUP_COUNT AND EXIT_NO > 0";
//        }
//        if($RESV_R==3){
//            $query3="EXIT_NO = GROUP_COUNT";
//        }
        if($ID_TG_R==0){
            $query2="ID_TG>0";
        }
        if($ID_TG_R!=0){
            $query2="ID_TG=".$ID_TG_R;
        }
//        if($OUT_IN_R==0){
//            $query3="OUT_IN>0";
//        }
//        if($OUT_IN_R!=0){
//            $query3="OUT_IN=".$OUT_IN_R;
//        }

//        $query4="DATE_SHAMSI>=".$date_exit_shamsi1;
//        $query5="DATE_SHAMSI<=".$date_exit_shamsi2;


        Querytext::where('id_user', $id_user)->delete();
        $query="SELECT * FROM ansaldo_out_ghataats WHERE ".$query2." ORDER BY ID_T DESC";
        // $query="SELECT * FROM mitsubishi_out_ghataats WHERE ID_T>0";
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        // $forms = DB::table('mitsubishi_tamirat_programs')->where('ID_T','>',0)->get()->toArray();
        return response()->json(['results'=> $requests,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS,'ID_USER'=>$id_user,'ID_USERS'=>$data3,'QUERY'=>$query]);
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
    public function report_queryp5($id)
    {
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data = DB::table('ansaldo_out_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS]);//,'ID_USERS'=>$ID_USERS
    }
    public function get_history($id)
    {
        $data = DB::table('savabegh_total_view')->where('ID_T',$id)->where('SAV_TYPE','O')->get()->toArray();
        return response()->json(['results'=> $data]);
    }

}
