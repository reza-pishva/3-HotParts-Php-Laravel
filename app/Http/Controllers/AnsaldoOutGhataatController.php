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
     * In this method we are going to save infoarmation into "ansaldo_out_ghataats" table.
     * this table is used to keep the properties of equipment sent to some places for reconstructure.
     * first we create an instance from the the class of its model.
     * then through request arguments we will retrieve values from its form located in our view and then we save it into "ansaldo_out_ghataats" table
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
        return response()->json(['message'=> 'this record was saved']);
    }
   /**
     * In this method we authorize the person who wants to open the form which we can initialize equipment which we want to send outside for 
     * reconstructure in this software.
     * first we get the id , first name and last name of current user.then we retrieve the groups that our user belongs to.
     * then we get the roles of this user from different groups which this user belongs to after first foreach.
     * in the second foreach we get the name of roles of this user that has and if it was admin or 'track_create_program' 
     * we return the view of ansaldo_out_program and at the same time we pass the type of equipment and reconstructurerer companies to this view
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
     * In this method we we will get the whole rows from "ansaldo_out_ghataats" table.
     * this data is the list of equipment which we send for reconstructure.
     * along with sending this data we need to send all types of equipment through json file to our view.
    */
    public function total()
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $data = DB::table('ansaldo_out_ghataats')->where('ID_T','>',0)->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS]);
    }
    /**
     * each user creates his/her own request for sending to the companies where this equipment is going to reconstructure
     * in this method we want to get all such requests created by our current user in the date that user has loged in.
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
        $data = DB::table('ansaldo_out_ghataats')->where('ID_USER',$id_user)->where('DATE_SHAMSI','>=',$current_date_shamsi)->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'current_user'=>$id_user,'current_date_shamsi'=>$g_d]);
    }
   /**
     * In this method we get the rows from ansaldo_out_ghataats table that current user has created.
     * then we get the last row created by current user in ansaldo_out_ghataats table.
     * in addition to this data we send type of equipment from ansaldo_type_ghataats table to our view.
     */
    public function onlyone()
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $ID_T=Ansaldo_out_ghataat::where('id_user',$id_user)->orderBy('ID_T', 'desc')->first()->ID_T;
        $data = DB::table('ansaldo_out_ghataats')->where('ID_T',$ID_T)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS]);
    }
    /**
     * in this method we want to get a request to send outside of power plant with specific id.
     * along with this row we need to have types of all equipment and the companies which are registered as reconstructor in the view.     
    */
    public function onlyone2($id)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $ID_BAS = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        $data = DB::table('ansaldo_out_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS,'ID_USERS'=>$data3]);
    /**
     * in this method we are going to remove a row from "ansaldo_out_ghataats" table.
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
     * in this method we are going to edit a row from "ansaldo_out_ghataats" table.
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
    /**
     * In this method we are going to create a report from "ansaldo_out_ghataats" table.
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
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
        $ID_TG_R=$request->input('ID_TG_R');
        if($ID_TG_R==0){
            $query2="ID_TG>0";
        }
        if($ID_TG_R!=0){
            $query2="ID_TG=".$ID_TG_R;
        }
        Querytext::where('id_user', $id_user)->delete();
        $query="SELECT * FROM ansaldo_out_ghataats WHERE ".$query2." ORDER BY ID_T DESC";
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_TGS'=>$ID_TGS,'ID_BAS'=>$ID_BAS,'ID_USER'=>$id_user,'ID_USERS'=>$data3,'QUERY'=>$query]);
    }
  
   /**
     * In this software we have different types of record registered for each device or equipment.
     * One of them is the record used for keeping the history of device which we have sent for reconstructure.
     * In this method we are going to get the list of devices with specific request(where('ID_T',$id)->where('SAV_TYPE','O')).
    */    
    public function get_history($id)
    {
        $data = DB::table('savabegh_total_view')->where('ID_T',$id)->where('SAV_TYPE','O')->get()->toArray();
        return response()->json(['results'=> $data]);
    }

}
