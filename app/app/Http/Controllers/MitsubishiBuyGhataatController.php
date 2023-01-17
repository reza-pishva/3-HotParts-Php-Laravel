<?php
namespace App\Http\Controllers;



use App\Mitsubishi_bazsaz;
use App\Mitsubishi_buy_ghataat;
use App\Mitsubishi_savabegh;
use App\Mitsubishi_seller;
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


class MitsubishiBuyGhataatController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $atp= new Mitsubishi_buy_ghataat();
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
                                                                    $ghataats =Mitsubishi_type_ghataat::all();
                                                                    $ats=Mitsubishi_bazsaz::all();
                                                                    $sellers=Mitsubishi_seller::all();
                                                                    return view('Mitsubishi.mitsubishi_buy_program',compact('ghataats','ats','sellers'));
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
        $data = DB::table('mitsubishi_out_ghataats')->where('ID_T','>',0)->orderBy('ID_T', 'DESC')->get()->toArray();
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
        $data = DB::table('mitsubishi_out_ghataats')->where('ID_T','>',0)->where('ID_USER',$id_user)->where('DATE_SHAMSI','>=',$current_date_shamsi)->orderBy('ID_T', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3,'current_date_shamsi'=>$g_d]);//->where('DATE_BEGIN1',$current_date_shamsi)
    }
    public function onlyone()
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_SES = DB::table('mitsubishi_sellers')->where('ID_SE','>',0)->get()->toArray();
        $ID_T= Mitsubishi_buy_ghataat::where('id_user',$id_user)->orderBy('ID_T', 'desc')->first()->ID_T;
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_buy_ghataats')->where('ID_T',$ID_T)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3,'ID_SES'=>$ID_SES]);
    }
    public function onlyone2($id)
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_SES = DB::table('mitsubishi_sellers')->where('ID_SE','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_buy_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3,'ID_SES'=>$ID_SES]);
    }
    public function delete($id){
        $n= Mitsubishi_savabegh::where('ID_T', $id)->where('SAV_TYPE','KH')->get()->count();
        if($n==0){
            Mitsubishi_buy_ghataat::where('ID_T', $id)->delete();
            return response()->json(['success'=>'hi','id_t'=>$id,'perm'=>1]);
        }else{
            return response()->json(['success'=>'hi','perm'=>0]);
        }
    }
    public function edit(Request $request)
    {
        $ID_T_EDIT=$request->input('ID_T_EDIT');
        $ID_TG_EDIT=$request->input('ID_TG_EDIT');
        $DISCRIPTION_EDIT=$request->input('DISCRIPTION_EDIT');
        $GROUP_COUNT_EDIT=$request->input('GROUP_COUNT_EDIT');
        $ID_SE_EDIT=$request->input('ID_SE_EDIT');
//        $BUY_CONDITION_EDIT=$request->input('BUY_CONDITION_EDIT');
        $SHOMAREH_GHARAR=$request->input('SHOMAREH_GHARAR_EDIT');
        $RESV_EDIT=$request->input('RESV_EDIT');
        $DATE_SHAMSI_EDIT=$request->input('DATE_SHAMSI_EDIT');
        $DATE_BEGIN_SH_array=explode('/',$DATE_SHAMSI_EDIT);
        $DATE_SHAMSI_EDIT=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);

        Mitsubishi_buy_ghataat::where('ID_T', $ID_T_EDIT)->update([
            'ID_TG'=>$ID_TG_EDIT,
            'GROUP_COUNT'=>$GROUP_COUNT_EDIT,
            'DISCRIPTION'=>$DISCRIPTION_EDIT,
            'RESV'=>$RESV_EDIT,
            'ID_SE'=>$ID_SE_EDIT,
//            'BUY_CONDITION'=>0,
            'SHOMAREH_GHARAR'=>$SHOMAREH_GHARAR,
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
        $ID_SES = DB::table('mitsubishi_sellers')->where('ID_SE','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
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
        $query="SELECT * FROM mitsubishi_buy_ghataats WHERE ".$query1." AND ".$query2." AND ".$query3." ORDER BY ID_T DESC";
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_USERS'=>$data3,'ID_TGS'=>$ID_TGS,'ID_SES'=>$ID_SES]);
    }
    public function report_queryp5($id)
    {
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_SES = DB::table('mitsubishi_sellers')->where('ID_SE','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_buy_ghataats')->where('ID_T',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_SES'=>$ID_SES]);//,'ID_USERS'=>$ID_USERS
    }
    public function get_history($id)
    {
        //$data = DB::table('mitsubishi_buy_prog_view')->where('ID_T',$id)->where('SAV_TYPE','KH')->get()->toArray();
        $data = DB::table('mitsubishi_tamirat_prog_view')->where('ID_T',$id)->where('SAV_TYPE','KH')->get()->toArray();
        return response()->json(['results'=> $data]);

    }
}