<?php
namespace App\Http\Controllers;

use App\Ansaldo_bazsaz;
use App\Ansaldo_buy_ghataat;
use App\Ansaldo_savabegh;
use App\Ansaldo_seller;
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


class AnsaldoBuyGhataatController extends Controller
{
    
    /**
     * In this method we store the buy request from different companies which sell power plant equipment.
     * first we get the id of current user to specify the requester of this buy request.
     * then we create an instance of the model Ansaldo_buy_ghataat.it is linked to the ansaldo_buy_ghataats table.
     * then we get the information such as some foriegn key from the form created for providing new buy request.
     * then we save them into 'Ansaldo_buy_ghataat' 
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $atp= new Ansaldo_buy_ghataat();
        $atp->ID_TG=$request->input('ID_TG');
        $atp->ID_SE=$request->input('ID_SE');
        $atp->GROUP_COUNT=$request->input('GROUP_COUNT');
        $atp->DISCRIPTION=$request->input('DISCRIPTION');
        $atp->SHOMAREH_GHARAR=$request->input('SHOMAREH_GHARAR');
        $atp->BUY_CONDITION=1;
        $atp->RESV=$request->input('RESV');
        $DATE_BEGIN1_array=explode('/',$request->input('DATE_SHAMSI'));
        $atp->DATE_SHAMSI=$this->convert($DATE_BEGIN1_array[0].$DATE_BEGIN1_array[1].$DATE_BEGIN1_array[2]);
        $atp->ID_USER=$id_user;
        $atp->save();
        return response()->json(['message'=> 'this request successfully was saved']);
    }   
    
    /**
     * In this method we authorize the person who wants to open the form which we can initialize buy request information in this software
     * first we get the id , first name and last name of current user.then we retrieve the groups that our user belongs to.
     * then we get the roles of this user from different groups which this user belongs to after first foreach.
     * in the second foreach we get the name of roles of this user that has and if it was admin or track_create_program 
     * we return the view of ansaldo_buy_program and at the same time we pass the name of equipment and sellers and reconstructurerer companies to this view
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
                   $ghataats =Ansaldo_type_ghataat::all();
                   $ats=Ansaldo_bazsaz::all();
                   $sellers=Ansaldo_seller::all();
                   return view('Ansaldo.ansaldo_buy_program',compact('ghataats','ats','sellers'));
                 }
              }
          }
         if($allow===0){
            return view('access_denied');
          }
    }
    
    /**
     * In this method we get the total rows from ansaldo_out_ghataats table. this table is used to store the cases that we send outside of company 
     * for reconstruction. 
     * in addition to this information we get the ids of the type of equipment .
     * after that we send these two data to our view.
     */ 
    public function total()
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $data = DB::table('ansaldo_out_ghataats')->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS]);
    }
    
  /**
     * In this method we are going to get the rows that current user has created during the day he has worked with this software.
     * so we get the day,month,year of the day. 
     * then we get the rows created by current user in that date in ansaldo_out_ghataats table.
     * in addition to this data we send type of equipment from ansaldo_type_ghataats table to our view.
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
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $data = DB::table('ansaldo_out_ghataats')->where('ID_USER',$id_user)->where('DATE_SHAMSI','>=',$current_date_shamsi)->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'current_date_shamsi'=>$g_d]);
    }
     
     /**
     * In this method we are going to get the rows from ansaldo_buy_ghataats table that current user has created.
     * then we get the last row created by current user in ansaldo_buy_ghataats table.
     * in addition to this data we send type of equipment from ansaldo_type_ghataats table and equpment sellers from ansaldo_sellers to our view.
     */    
    public function onlyone()
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $ID_SES = DB::table('ansaldo_sellers')->get()->toArray();
        $ID_T= Ansaldo_buy_ghataat::where('id_user',$id_user)->orderBy('ID_T', 'desc')->first()->ID_T;
        $data = DB::table('ansaldo_buy_ghataats')->where('ID_T',$ID_T)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_SES'=>$ID_SES]);
    }   
    
     /**
     * In this method we are going to get the rows from ansaldo_buy_ghataats with specific id from ansaldo_tamirat_programs table.
     * in addition to this data we send type of equipment from ansaldo_type_ghataats table and equpment sellers from ansaldo_sellers to our view.
     */    
    public function onlyone2($id)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $ID_SES = DB::table('ansaldo_sellers')->get()->toArray();
        $data = DB::table('ansaldo_buy_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_SES'=>$ID_SES]);
    }
     /**
     * In this method we remove a row from ansaldo_buy_ghataats.but we should note that the id 
     * which we want to remove from this table should not be used in ansaldo_savabeghs table as forign key.
     * then we send the id to our view and set perm(permission) one for removing.
     * otherwise we  set perm(permission) zero to the view to show appropriate alert to the user.
     */   
    public function delete($id){
        $n= Ansaldo_savabegh::where('ID_T', $id)->where('SAV_TYPE','KH')->get()->count();
        if($n==0){
            Ansaldo_buy_ghataat::where('ID_T', $id)->delete();
            return response()->json(['success'=>'true','id_t'=>$id,'perm'=>1]);
        }else{
            return response()->json(['success'=>'true','perm'=>0]);
        }
    }
    
    
     /**
     * In this method we are going to edit the fields of ansaldo_buy_ghataats table with specific id
     */
    public function edit(Request $request)
    {
        $ID_T_EDIT=$request->input('ID_T_EDIT');
        $ID_TG_EDIT=$request->input('ID_TG_EDIT');
        $DISCRIPTION_EDIT=$request->input('DISCRIPTION_EDIT');
        $GROUP_COUNT_EDIT=$request->input('GROUP_COUNT_EDIT');
        $ID_SE_EDIT=$request->input('ID_SE_EDIT');
        $SHOMAREH_GHARAR=$request->input('SHOMAREH_GHARAR_EDIT');
        $RESV_EDIT=$request->input('RESV_EDIT');
        $DATE_SHAMSI_EDIT=$request->input('DATE_SHAMSI_EDIT');
        $DATE_BEGIN_SH_array=explode('/',$DATE_SHAMSI_EDIT);
        $DATE_SHAMSI_EDIT=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);

        Ansaldo_buy_ghataat::where('ID_T', $ID_T_EDIT)->update([
            'ID_TG'=>$ID_TG_EDIT,
            'GROUP_COUNT'=>$GROUP_COUNT_EDIT,
            'DISCRIPTION'=>$DISCRIPTION_EDIT,
            'RESV'=>$RESV_EDIT,
            'ID_SE'=>$ID_SE_EDIT,
            'SHOMAREH_GHARAR'=>$SHOMAREH_GHARAR,
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
     * In this method we are going to create a report from ansaldo_buy_ghataats table.
     * first we get some information from base tables which we want to use them in where part of our select command.
     * then we will get some data from our search form to be used in where part of our select command as well.
     * for the field that we do not want to set anything in our where part we will use '>0' for their id to cover all possible values.
     * in the end we stick all these part together to create a raw query.
     * after that we will save this query string and the id of the user who creates this report in the querytext table.
     * then we will use DB::select command to use this raw query and send it to our view as json file.
     */
    public function report_queryp(Request $request)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $ID_SES = DB::table('ansaldo_sellers')->get()->toArray();
        $id_user = auth()->user()->id;
        $ID_TG_R=$request->input('ID_TG_R');
        $ID_SE_R=$request->input('ID_SE_R');
        $RESV_R=$request->input('RESV_R');
        if($RESV_R==''){
            $query1="RESV>=0";
        }
        if($RESV_R!=''){
            $query1="RESV=".$RESV_R;
        }
        if($ID_TG_R==0){
            $query2="ID_TG>0";
        }
        if($ID_TG_R!=0){
            $query2="ID_TG=".$ID_TG_R;
        }
        if($ID_SE_R==0){
            $query3="ID_SE>0";
        }
        if($ID_SE_R!=0){
            $query3="ID_SE=".$ID_SE_R;
        }
        Querytext::where('id_user', $id_user)->delete();
        $query="SELECT * FROM ansaldo_buy_ghataats WHERE ".$query1." AND ".$query2." AND ".$query3." ORDER BY ID_T DESC";
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_TGS'=>$ID_TGS,'ID_SES'=>$ID_SES]);
    }
    public function report_queryp5($id)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $ID_SES = DB::table('ansaldo_sellers')->get()->toArray();
        $data = DB::table('ansaldo_buy_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_SES'=>$ID_SES]);
    }
    public function get_history($id)
    {
        //$data = DB::table('ansaldo_buy_prog_view')->where('ID_T',$id)->where('SAV_TYPE','KH')->get()->toArray();
        $data = DB::table('ansaldo_tamirat_prog_view')->where('ID_T',$id)->where('SAV_TYPE','KH')->get()->toArray();
        return response()->json(['results'=> $data]);

    }
}
