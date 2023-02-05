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

use App\Grouprole;
use App\Groupuser;
use App\Request_level;
use App\Role;
use App\User_role;



class AnsaldoSendBazsaziGhataatController extends Controller
{

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
     * we return the view of ansaldo_send_program and at the same time we pass the type of equipment and reconstructor companies to this view
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
     * along with this data we need to have types of all equipment and the id of our current user and reconstructor companies in the view.     
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
    /**
     * In this method we get the rows from ansaldo_send_bazsazi_ghataats table that current user has created.
     * then we get the last row created by current user in ansaldo_send_bazsazi_ghataats table.
     * in addition to this data we send type of equipment from ansaldo_type_ghataats and and reconstructor companies from ansaldo_bazsazs table to our view.
     */
    public function onlyone()
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->get()->toArray();
        $ID_T=Ansaldo_send_bazsazi_ghataat::where('id_user',$id_user)->orderBy('ID_T', 'desc')->first()->ID_T;
        $data = DB::table('ansaldo_send_bazsazi_ghataats')->where('ID_T',$ID_T)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS]);
    }
   /**
     * in this method we want to get a request to send outside of power plant with specific id.
     * along with this row we need to have types of all equipment and the companies which are registered as reconstructor in the view.     
    */
    public function onlyone2($id)
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->get()->toArray();
        $data = DB::table('ansaldo_send_bazsazi_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS]);
    }
   /**
     * in this method we are going to remove a row from "ansaldo_out_ghataats" table.
     * before removing the row ,we will check if there is any row with this id in the history of that equipment.     
    */
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
    /**
     * in this method we are going to edit a row from "ansaldo_send_bazsazi_ghataats" table.
    */
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
   /**
     * In this method we are going to convert latin numbers into persian numbers.
    */
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
   /**
     * In this method we are going to create a report from "bazsazi_view" view.
     * first we get some information from base tables which we want to use them in where part of our select command.
     * then we will get some data from our search form to be used in where part of our select command as well.
     * for the field that we do not want to set anything in our where part we will use '>0' for their id to cover all possible values.
     * in the end we stick all these part together to create a raw query.
     * after that we will save this query string and the id of the user who creates this report in the querytext table.
     * then we will use DB::select command to use this raw query and send it to our view as json file.
     */
    public function report_queryp(Request $request)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
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
        return response()->json(['results'=> $requests,'ID_BAS'=>$ID_BAS,'ID_TGS'=>$ID_TGS,'ID_TTS'=>$RESV_R,'ID_USER'=>$id_user,'QUERY'=>$query]);
    }

}
