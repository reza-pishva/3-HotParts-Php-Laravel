<?php
namespace App\Http\Controllers;
use App\Ansaldo_tamirkaran;
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


class AnsaldoTamirkarController extends Controller
{
    /**
     * In this method we are going to save infoarmation into "ansaldo_tamirkarans" table.
     * this table is used to keep the properties of companies which are in charge of repaiments the power plant.
     * first we create an instance from the the class of its model.
     * then through request arguments we will retrieve values from its form located in our view and then we save it into "ansaldo_tamirkarans" table
     * then we send a message and the id of the seller compamies which through a json file to our view.
    */
    public  function tamirkar_store(Request $request){
        $id_user=auth()->user()->id;
        $tamirkar= new Ansaldo_tamirkaran();
        $tamirkar->TAMIRKAR=$request->input('TAMIRKAR');
        $tamirkar->ID_USER=$id_user;
        $tamirkar->save();
        $id_ta = DB::table('ansaldo_tamirkarans')->where('ID_USER',$id_user)->orderBy('ID_TA', 'DESC')->first()->ID_TA;
        return response()->json(['success'=>'it was saved','id_ta'=>$id_ta]);
    }
   /**
     * In this method we will get the whole rows from "ansaldo_tamirkarans" table.
     * this data is the list of companies which are in charge of repaiments the power plant.
    */
    public function tamirkar_total()
    {
        $data = DB::table('ansaldo_tamirkarans')->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    /**
     * in this method we are going to remove a row from "ansaldo_tamirkarans" table.
     * before removing the row ,we will check if there is any row with this id in ansaldo_tamirat_programs table.     
    */
    public function delete($id){
        $n= DB::table('ansaldo_tamirat_programs')->where('ID_TA',$id)->get()->count();
        if($n==0){
            Ansaldo_tamirkaran::where('ID_TA', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
    /**
     * in this method we are going to edit a row from "ansaldo_tamirkarans" table.
    */
    public function tamirkar_edit(Request $request)
    {
        $id_se=$request->input('ID_TA_EDIT');
        $seller=$request->input('TAMIRKAR_EDIT');
        Ansaldo_tamirkaran::where('ID_TA', $id_se)->update(['TAMIRKAR'=>$seller]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
