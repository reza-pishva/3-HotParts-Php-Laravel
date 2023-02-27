<?php
namespace App\Http\Controllers;


use App\Ansaldo_tamirat_type;
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


class AnsaldoTamirattyController extends Controller
{
    /**
     * In this method we are going to save infoarmation into "ansaldo_tamirat_types" table.
     * this table is used to keep the type of repairments in the power plant.
     * first we create an instance from the the class of its model.
     * then through request arguments we will retrieve values from its form located in our view and then we save it into "ansaldo_tamirat_types" table
     * then we send a message and the id of "ansaldo_tamirat_types" table through a json file to our view.
    */
    public  function tamiratty_store(Request $request){
        $id_user=auth()->user()->id;
        $bazsaz= new Ansaldo_tamirat_type();
        $bazsaz->TAMIRAT_TYPE=$request->input('TAMIRAT_TYPE');
        $bazsaz->ID_USER=$id_user;
        $bazsaz->save();
        $id_tt = DB::table('ansaldo_tamirat_types')->where('ID_USER',$id_user)->orderBy('ID_TT', 'DESC')->first()->ID_TT;
        return response()->json(['success'=>'hi','id_tt'=>$id_tt]);//,'id_ba'=>$id_ba
    }
   /**
     * In this method we will get the whole rows from "ansaldo_tamirat_types" table.
     * this data is the list of types of repairments in the power plant.
    */
    public function tamiratty_total()
    {
        $data = DB::table('ansaldo_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
   /**
     * in this method we are going to remove a row from "ansaldo_tamirat_types" table.
     * before removing the row ,we will check if there is any row with this id in the ansaldo_tamirat_programs table.     
    */
    public function delete($id){
        $n= DB::table('ansaldo_tamirat_programs')->where('ID_TT',$id)->get()->count();
        if($n==0){
            Ansaldo_tamirat_type::where('ID_TT', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
   /**
     * in this method we are going to edit a row from "ansaldo_tamirat_types" table.
    */
    public function tamiratty_edit(Request $request)
    {
        $id_tt=$request->input('ID_TT_EDIT');
        $type=$request->input('TAMIRAT_TYPE_EDIT');
        Ansaldo_tamirat_type::where('ID_TT', $id_tt)->update(['TAMIRAT_TYPE'=>$type]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}

