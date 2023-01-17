<?php
namespace App\Http\Controllers;



use App\Mitsubishi_group_name;
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


class MitsubishiGroupNamesController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $atp= new Mitsubishi_group_name();
        $atp->ID_TG=$request->input('ID_TG');
        $atp->GROUP_CODE=$request->input('GROUP_CODE');
        $atp->GROUP_TYPE=$request->input('GROUP_TYPE');
        $atp->ID_USER=$id_user;
        $atp->save();
        $n= Mitsubishi_group_name::where('GROUP_CODE',$request->input('GROUP_CODE'))->get()->count();
        if($n>1){
            $ID_G= Mitsubishi_group_name::where('ID_G','>',0)->orderBy('ID_G', 'desc')->first()->ID_G;
            Mitsubishi_group_name::where('ID_G', $ID_G)->delete();
            return response()->json(['message'=> 'hi','repeat'=>1]);
        }
        return response()->json(['message'=> 'hi']);
    }
    public function create()
    {
        $sazs = DB::table('mitsubishi_sazandehs')->where('ID_S','>',0)->get()->toArray();
        $requests = DB::table('mitsubishi_group_names')->where('ID_G','>',0)->orderBy('ID_G', 'DESC')->get()->toArray();
        $ghataats =Mitsubishi_type_ghataat::all();
        return view('Mitsubishi.mitsubishi_group_name',compact('requests','ghataats','sazs'));
    }
    public function total()
    {
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_group_names')->where('ID_G','>',0)->orderBy('ID_G', 'DESC')->get()->toArray();
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
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_group_names')->where('ID_G','>',0)->where('ID_USER',$id_user)->where('DATE_SHAMSI','>=',$current_date_shamsi)->orderBy('ID_G', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3,'current_date_shamsi'=>$g_d]);//->where('DATE_BEGIN1',$current_date_shamsi)
    }
    public function onlyone()
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $ID_G= Mitsubishi_group_name::where('id_user',$id_user)->orderBy('ID_G', 'desc')->first()->ID_G;
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_group_names')->where('ID_G',$ID_G)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);
    }
    public function onlyone2($id)
    {
        $id_user = auth()->user()->id;
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $data = DB::table('mitsubishi_group_names')->where('ID_G',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3]);//,'ID_USERS'=>$ID_USERS
    }
    public function delete($id){
        $rec_no = DB::table('mitsubishi_ghataats')->where('ID_G',$id)->get()->count();
        if($rec_no>0){
            return response()->json(['success'=>'hi','rec_no'=>1]);
        }else{
            Mitsubishi_group_name::where('ID_G', $id)->delete();
            return response()->json(['success'=>'hi','rec_no'=>0]);
        }
    }
    public function edit(Request $request)
    {
        $ID_G_EDIT=$request->input('ID_G_EDIT');
        $ID_TG_EDIT=$request->input('ID_TG_EDIT');
        $GROUP_CODE_EDIT=$request->input('GROUP_CODE_EDIT');
        $GROUP_TYPE_EDIT=$request->input('GROUP_TYPE_EDIT');
        Mitsubishi_group_name::where('ID_G', $ID_G_EDIT)->update([
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
        $ID_TGS = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        $data3 = DB::table('users')->where('id','>',0)->get()->toArray();
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        $id_user = auth()->user()->id;
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
        $query="SELECT * FROM mitsubishi_group_names WHERE ".$query1." AND ".$query2."  ORDER BY ID_G DESC";//
        $value=['id_user'=>$id_user,'query_text'=>$query];
        DB::table('querytexts')->insert($value);
        $requests = DB::select(DB::raw($query));
        return response()->json(['results'=> $requests,'ID_TGS'=>$ID_TGS,'ID_USER'=>$id_user,'ID_USERS'=>$data3,'QUERY'=>$query]);
    }
}