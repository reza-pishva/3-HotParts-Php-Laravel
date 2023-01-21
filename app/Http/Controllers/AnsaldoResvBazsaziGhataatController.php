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



class AnsaldoResvBazsaziGhataatController extends Controller
{
    /**
     * in this method we are going to save some information into 'ansaldo_resv_bazsazi_ghataats'.this table is used to maintain information about 
     * our request for sending and recieving devices and equipment to companies which is in charge of reconstructing.in addition to simple properties
     * that we get from the form created to post data to this method we should upload document about our request.So we will use 'Validator::make('
     * to validate the items we want to upload and then we create an instance from  'Ansaldo_resv_bazsazi_ghataat' model. before saving this information
     * we should compute the number of devices that we get from companies and we should compare it with the total number of devices that we have sent through 
     * different request. it is clear that it should not more than the total number of devices that we have sent through 
     * different request.
     */
    public  function store(Request $request){
        $validation = Validator::make($request->all(), [
            'select_file' => 'mimes:jpeg,bmp,png,gif,svg,pdf,pptx,xls,xlsx,docx,csv,rar,zip|max:10240'
        ]);
        $id_user=auth()->user()->id;
        $atp= new Ansaldo_resv_bazsazi_ghataat();
        $atp->ID_T=$request->input('ID_T');
        $atp->COUNT_GH=$request->input('COUNT_GH');
        $atp->ID_USER=$id_user;
        if($request->input('RESV')==1){
            $atp->RESV =1;
        }else{
            $atp->RESV =2;
        }

        if($request->input('DATE_SHAMSI')==''){
            $DATE_BEGIN_SH_array='---';
        }else{
            $DATE_BEGIN_SH_array=explode('/',$request->input('DATE_SHAMSI'));
        }
        $atp->DATE_SHAMSI=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);
        if($request->file('select_file')){
            if($validation->failed()==false)
            {
                if (DB::table('ansaldo_resv_bazsazi_ghataats')->where('ID_SUB','>',0)->exists()){
                    $id_t = (DB::table('ansaldo_resv_bazsazi_ghataats')->where('ID_SUB','>',0)->orderBy('ID_SUB', 'DESC')->first()->ID_SUB)+1;
                }
                else{
                    $id_t = 1;
                }

                $image = $request->file('select_file');
                $new_name = (string) $id_t. '.' . $image->getClientOriginalExtension();
                $exten=$image->getClientOriginalExtension();
                $image->move(public_path('images'), $new_name);
                $atp->FILE_NAME=(string) $id_t.'R.'.$exten;
            }
        }
        else{
            $atp->FILE_NAME='فایل پیوست ندارد';
        }

        $atp->save();

        $sum = Ansaldo_resv_bazsazi_ghataat::where('ID_T', $request->input('ID_T'))->sum('COUNT_GH');
        Ansaldo_send_bazsazi_ghataat::where('ID_T',$request->input('ID_T'))->update(['EXIT_NO'=>$sum]);
        $GROUP_COUNT=Ansaldo_send_bazsazi_ghataat::where('ID_T', $request->input('ID_T'))->orderBy('ID_T', 'desc')->first()->GROUP_COUNT;
        $error=0;
        if($GROUP_COUNT<$sum){
            $error=1;
            $ID_SUB=Ansaldo_resv_bazsazi_ghataat::where('ID_SUB','>',0)->orderBy('ID_SUB', 'desc')->first()->ID_SUB;
            Ansaldo_resv_bazsazi_ghataat::where('ID_SUB', $ID_SUB)->delete();
        }else{
            $error=0;
        }

        return response()->json(['message'=> $request->file('select_file'),'sum'=>$error]);
    }
    /**
     * in this method we are going to get all rows from 'ansaldo_resv_bazsazi_ghataats' with specific id of the program we defined(it could be maintenance program
     * or reconstructure program and ...) our request for sending and recieving devices and equipment to companies which is in charge of reconstructing.
     * in addition to simple properties
     */
    public function total($id)
    {
        $data = DB::table('ansaldo_resv_bazsazi_ghataats')->where('ID_T',$id)->orderBy('ID_SUB', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    /**
     * in this method we are going to remove a row from '' table
     * or reconstructure program and ...) our request for sending and recieving devices and equipment to companies which is in charge of reconstructing.
     * in addition to simple properties
     */
    public function delete($id){
        $n= DB::table('ansaldo_savabeghs')->where('SAV_TYPE','B')->where('ID_SUB',$id)->get()->count();
        if($n==0){
            Ansaldo_resv_bazsazi_ghataat::where('ID_SUB', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
    public function edit(Request $request)
    {
        $ID_SUB_EDIT=$request->input('ID_SUB_EDIT');
        $FILE_NAME_EDIT=DB::table('ansaldo_resv_bazsazi_ghataats')->where('ID_SUB',$ID_SUB_EDIT)->orderBy('ID_SUB', 'DESC')->first()->FILE_NAME;
        $validation = Validator::make($request->all(), [
            'select_file_edit' => 'mimes:jpeg,bmp,png,gif,svg,pdf,pptx,xls,xlsx,docx,csv,rar,zip|max:10240'
        ]);
        $ID_T_EDIT=$request->input('ID_T_EDIT');
        $COUNT_GH_EDIT=$request->input('COUNT_GH_EDIT');
        // $DATE_BEGIN_SH=$request->input('DATE_SHAMSI_EDIT');
        //$DATE_BEGIN_SH_array=explode('/',$DATE_BEGIN_SH);
        //$DATE_SHAMSI_EDIT=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);
        if($request->input('RESV_EDIT')==1){
            $RESV =1;
        }else{
            $RESV =2;
        }
        if($request->input('DATE_SHAMSI_EDIT')==''){
            $DATE_BEGIN_SH_array='---';
            $DATE_SHAMSI_EDIT='---';
        }else{
            $DATE_BEGIN_SH_array=explode('/',$request->input('DATE_SHAMSI_EDIT'));
            $DATE_SHAMSI_EDIT=$this->convert($DATE_BEGIN_SH_array[0].$DATE_BEGIN_SH_array[1].$DATE_BEGIN_SH_array[2]);
        }
        if($request->file('select_file_edit')){
            $image = $request->file('select_file_edit');
            $new_name = (string) $ID_SUB_EDIT. '.' . $image->getClientOriginalExtension();
            $exten=$image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            $FILE_NAME_EDIT=(string) $ID_SUB_EDIT.'R.'.$exten;
            Ansaldo_resv_bazsazi_ghataat::where('ID_SUB', $ID_SUB_EDIT)->update([
                'FILE_NAME'=>$FILE_NAME_EDIT,
                'ID_T'=>$ID_T_EDIT,
                'RESV'=>$RESV,
                'COUNT_GH'=>$COUNT_GH_EDIT,
                'DATE_SHAMSI'=>$DATE_SHAMSI_EDIT]);
        }else{
            Ansaldo_resv_bazsazi_ghataat::where('ID_SUB', $ID_SUB_EDIT)->update([
                'FILE_NAME'=>$FILE_NAME_EDIT,
                'ID_T'=>$ID_T_EDIT,
                'RESV'=>$RESV,
                'COUNT_GH'=>$COUNT_GH_EDIT,
                'DATE_SHAMSI'=>$DATE_SHAMSI_EDIT]);
        }

        $sum = Ansaldo_resv_bazsazi_ghataat::where('ID_T', $request->input('ID_T_EDIT'))->sum('COUNT_GH');
        Ansaldo_send_bazsazi_ghataat::where('ID_T',$request->input('ID_T_EDIT'))->update(['EXIT_NO'=>$sum]);
        $GROUP_COUNT=Ansaldo_send_bazsazi_ghataat::where('ID_T', $request->input('ID_T_EDIT'))->orderBy('ID_T', 'desc')->first()->GROUP_COUNT;
        $error=0;
        if($GROUP_COUNT<$sum){
            $error=1;
        }

        return response()->json(['success'=>'the information has successfuly saved','FILE'=>$FILE_NAME_EDIT,'sum'=>$error]);
    }
    public function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $string);
        return $englishNumbersOnly;
    }
    public function get_history($id)
    {
        $data = DB::table('savabegh_total_view')->where('ID_SUB',$id)->where('SAV_TYPE','B')->get()->toArray();
        return response()->json(['results'=> $data]);

    }
    public function get_history2($id)
    {
        $data = DB::table('savabegh_total_view')->where('ID_T',$id)->where('SAV_TYPE','B')->get()->toArray();
        return response()->json(['results'=> $data]);

    }
}
