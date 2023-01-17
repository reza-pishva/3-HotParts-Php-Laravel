<?php
namespace App\Http\Controllers;


use App\Mitsubishi_store_program_in;
use App\Mitsubishi_store_program_out;
use App\Mitsubishi_tamirat_type;
use App\Mitsubishi_tamirkaran;
use App\Mitsubishi_type_ghataat;
use App\Mitsubishi_unit_number;
use App\Querytext;
use App\CalendarHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;



class MitsubishiStoreProgramOutController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $atp= new Mitsubishi_store_program_out();
        $atp->ID_T=$request->input('ID_T');
        $atp->COUNT_GH=$request->input('COUNT_GH');
        $atp->ID_USER=$id_user;
        if($request->input('RESV')==1){
            $atp->RESV =1;
        }else{
            $atp->RESV =2;
        }
        if($request->input('DATE_SHAMSI2')==''){
            $DATE_BEGIN_SH_array='---';
        }else{
            $DATE_BEGIN_SH_array=explode('/',$request->input('DATE_SHAMSI2'));
        }
        
        $atp->DATE_SHAMSI2=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);
        $atp->save();
        $sum = Mitsubishi_store_program_out::where('ID_T', $request->input('ID_T'))->sum('COUNT_GH');
        Mitsubishi_store_program_in::where('ID_T',$request->input('ID_T'))->update(['EXIT_NO'=>$sum]);
        $GROUP_COUNT=Mitsubishi_store_program_in::where('ID_T', $request->input('ID_T'))->orderBy('ID_T', 'desc')->first()->GROUP_COUNT;
        $error=0;
        if($GROUP_COUNT<$sum){
            $error=1;
            $ID_SUB=Mitsubishi_store_program_out::where('ID_SUB','>',0)->orderBy('ID_SUB', 'desc')->first()->ID_SUB;
            Mitsubishi_store_program_out::where('ID_SUB', $ID_SUB)->delete();
        }else{
            $error=0;
        }

        return response()->json(['message'=> 'hi','sum'=>$error]);
    }
    public function total($id)
    {
        $data = DB::table('mitsubishi_resv_bazsazi_ghataats')->where('ID_T',$id)->orderBy('ID_SUB', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);//,'ID_USERS'=>$ID_USERS
    }
    public function resvs_for_out($id)
    {
        $data = DB::table('mitsubishi_store_program_outs')->where('ID_T',$id)->orderBy('ID_SUB', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);//,'ID_USERS'=>$ID_USERS
    }
    public function delete($id,$id_t){
        $n= DB::table('mitsubishi_savabeghs')->where('SAV_TYPE','A')->where('ID_SUB',$id)->get()->count();
        if($n==0){
            Mitsubishi_store_program_out::where('ID_SUB', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
    public function edit(Request $request)
    {
        $ID_SUB_EDIT=$request->input('ID_SUB_EDIT');
        $ID_T_EDIT=$request->input('ID_T_EDIT');
        $COUNT_GH_EDIT=$request->input('COUNT_GH_EDIT');
        $DATE_BEGIN_SH=$request->input('DATE_SHAMSI2_EDIT');
        if($DATE_BEGIN_SH ==''){
            $DATE_SHAMSI_EDIT='---';
        }else{
            $DATE_BEGIN_SH_array=explode('/',$DATE_BEGIN_SH);
            $DATE_SHAMSI_EDIT=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);
        }
        
        if($request->input('RESV_EDIT')==1){
            $RESV =1;
        }else{
            $RESV =2;
        }
        Mitsubishi_store_program_out::where('ID_SUB', $ID_SUB_EDIT)->update([
        'ID_T'=>$ID_T_EDIT,
        'RESV'=>$RESV,
        'COUNT_GH'=>$COUNT_GH_EDIT,
        'DATE_SHAMSI2'=>$DATE_SHAMSI_EDIT]);
        $sum = Mitsubishi_store_program_out::where('ID_T', $request->input('ID_T_EDIT'))->sum('COUNT_GH');
        Mitsubishi_store_program_in::where('ID_T',$request->input('ID_T_EDIT'))->update(['EXIT_NO'=>$sum]);
        $GROUP_COUNT=Mitsubishi_store_program_in::where('ID_T', $request->input('ID_T_EDIT'))->orderBy('ID_T', 'desc')->first()->GROUP_COUNT;
        $error=0;
        if($GROUP_COUNT<$sum){
            $error=1;
        }

        return response()->json(['success'=>'the information has successfuly saved','sum'=>$error]);
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function get_history($id)
    {
//        $data = DB::table('mitsubishi_tamirat_prog_view')->where('ID_SUB',$id)->where('SAV_TYPE','A')->get()->toArray();
        $data = DB::table('m_savabegh_total_view')->where('ID_SUB',$id)->where('SAV_TYPE','A')->get()->toArray();
        return response()->json(['results'=> $data]);

    }
    public function get_history2($id)
    {
        $data = DB::table('m_savabegh_total_view')->where('ID_T',$id)->where('SAV_TYPE','A')->get()->toArray();
        return response()->json(['results'=> $data]);

    }
    public function update_exit_no()
    {
        $requests=Mitsubishi_store_program_in::all();
        foreach($requests as $request):
            $id_t=$request->ID_T;
            $sum = Mitsubishi_store_program_out::where('ID_T', $id_t)->sum('COUNT_GH');
            Mitsubishi_store_program_in::where('ID_T',$request->ID_T)->update(['EXIT_NO'=>$sum]);
        endforeach;
        return response()->json(['results'=>'HI']);
    }

}