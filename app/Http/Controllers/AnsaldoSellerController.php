<?php
namespace App\Http\Controllers;


use App\Ansaldo_seller;
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


class AnsaldoSellerController extends Controller
{
    /**
     * In this method we are going to save infoarmation into "ansaldo_sellers" table.
     * this table is used to keep the properties of companies selling devices and equipment to the power plant.
     * first we create an instance from the the class of its model.
     * then through request arguments we will retrieve values from its form located in our view and then we save it into "ansaldo_sellers" table
     * then we send a message and the id of the seller compamies which through a json file to our view.
    */
    public  function seller_store(Request $request){
        $id_user=auth()->user()->id;
        $seller= new Ansaldo_seller();
        $seller->SELLER=$request->input('SELLER');
        $seller->ID_USER=$id_user;
        $seller->save();
        $id_se = DB::table('ansaldo_sellers')->where('ID_USER',$id_user)->orderBy('ID_SE', 'DESC')->first()->ID_SE;
        return response()->json(['success'=>'hi','id_ba'=>$id_se]);//,'id_ba'=>$id_ba
    }
    /**
     * In this method we will get the whole rows from "ansaldo_sellers" table.
     * this data is the list of companies which we buy our needs from them.
    */
    public function seller_total()
    {
        $data = DB::table('ansaldo_sellers')->where('ID_SE','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    /**
     * in this method we are going to remove a row from "ansaldo_sellers" table.
     * before removing the row ,we will check if there is any row with this id in the history of that equipment.     
    */
    public function delete($id){
        $n= DB::table('ansaldo_buy_ghataats')->where('ID_SE',$id)->get()->count();
        if($n==0){
            Ansaldo_seller::where('ID_SE', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }

    }
   /**
     * in this method we are going to edit a row from "ansaldo_sellers" table.
    */
    public function seller_edit(Request $request)
    {
        $id_se=$request->input('ID_SE_EDIT');
        $seller=$request->input('SELLER_EDIT');
        Ansaldo_seller::where('ID_SE', $id_se)->update(['SELLER'=>$seller]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
