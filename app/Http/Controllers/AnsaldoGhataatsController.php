<?php
namespace App\Http\Controllers;



use App\Ansaldo_ghataat;
use App\Ansaldo_group_name;
use App\Ansaldo_savabegh;
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


class AnsaldoGhataatsController extends Controller
{
    /**
     * In this method we are going to save infoarmation into "ansaldo_ghataats" table.
     * this table is used to keep the properties of equipment used in hot parts of power plant.
     * first we create an instance from the the class of its model.
     * then through request arguments we will retrieve values from its form located in our view and then we save it into "ansaldo_ghataats" table
     * then we send a message and the the id of the group which this part belongs to through a json file to our view.
    */
    public  function store(Request $request){
        $atp= new Ansaldo_ghataat();
        $atp->ID_G=$request->input('ID_G');
        $atp->REAL_SOURE=$request->input('REAL_SOURE');
        $atp->SERIYAL_NUMBER=$request->input('SERIYAL_NUMBER');
        $atp->MAKER=$request->input('MAKER');
        $atp->SERIAL_NUMBER2=$request->input('SERIAL_NUMBER2');
        $atp->save();
        return response()->json(['message'=> 'this information was successfully saved','ID_G'=>$request->input('ID_G')]);
    }
    /**
     * In this method we we will get the whole rows from "ansaldo_ghataats" table.
     * along with sending this data we need to send all types of equipment through json file to our view.
    */
    public function total()
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $data = DB::table('ansaldo_ghataats')->orderBy('ID_E', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS]);
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
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $data = DB::table('ansaldo_group_names')->where('ID_USER',$id_user)->where('DATE_SHAMSI','>=',$current_date_shamsi)->orderBy('ID_G', 'DESC')->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS,'ID_USERS'=>$data3,'current_date_shamsi'=>$g_d]);
    }
    /**
     * in this method we want to get the name of a group with specific id.
     * along with this row we need to have types of all equipment in the view.     
    */
    public function onlyone2($id)
    {
        $ID_TGS = DB::table('ansaldo_type_ghataats')->get()->toArray();
        $data = DB::table('ansaldo_group_names')->where('ID_G',$id)->get()->toArray();
        return response()->json(['results'=> $data,'ID_TGS'=>$ID_TGS]);
    }
   /**
     * in this method we are going to remove a row from "ansaldo_ghataats" table.
     * before removing the row ,we will check if there is any row with this id in the history of that equipment.     
    */
    public function delete($id){
        $n= Ansaldo_savabegh::where('ID_E', $id)->get()->count();
        if($n==0){
            Ansaldo_ghataat::where('ID_E', $id)->delete();
            return response()->json(['success'=>'this record was romoved','n'=>1]);
        }else{
            return response()->json(['success'=>'you can not remove it','n'=>0]);
        }
    }
   /**
     * in this method we are going to edit a row from "ansaldo_ghataats" table.
     * before updating the row ,we check if there is any row with the same serial number exists in that table.  
     * if there was,user can not edit that row.  
    */
    public function edit(Request $request)
    {
        $ID_E_EDIT=$request->input('ID_E_EDIT2');
        $ID_G_EDIT=$request->input('ID_G_EDIT');
        $SERIYAL_NUMBER_EDIT=$request->input('SERIYAL_NUMBER_EDIT');
        $SERIAL_NUMBER2_EDIT=$request->input('SERIAL_NUMBER2_EDIT');
        $MAKER_EDIT=$request->input('MAKER_EDIT');
        $REAL_SOURE_EDIT=$request->input('REAL_SOURE_EDIT');
        $n= Ansaldo_ghataat::where('SERIYAL_NUMBER',$SERIYAL_NUMBER_EDIT)->where('ID_E','!=',$ID_E_EDIT)->get()->count();
        if($n>=1){
            return response()->json(['message'=> 'you can not change it','repeat'=>1]);
        }
        Ansaldo_ghataat::where('ID_E', $ID_E_EDIT)->update([
            'SERIYAL_NUMBER'=>$SERIYAL_NUMBER_EDIT,
            'SERIAL_NUMBER2'=>$SERIAL_NUMBER2_EDIT,
            'MAKER'=>$MAKER_EDIT,
            'REAL_SOURE'=>$REAL_SOURE_EDIT]);
        return response()->json(['success'=>'the information has successfuly saved','ID_G'=>$ID_G_EDIT,'repeat'=>0]);
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

    



}
