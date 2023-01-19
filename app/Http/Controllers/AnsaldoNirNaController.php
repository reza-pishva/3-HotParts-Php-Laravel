<?php
namespace App\Http\Controllers;
use App\Ansaldo_nirogah_name;
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


class AnsaldoNirNaController extends Controller
{
   /**
     * In this method we store power plant names into 'ansaldo_nirogah_names' table.
     * first we get the id of current user to specify the requester of this buy request.
     * then we create an instance of the model Ansaldo_nirogah_name.it is linked to the 'ansaldo_nirogah_names' table.
     * then we get the information such as some foriegn key from the form created for providing new power plant name.
     * then we save them into 'ansaldo_nirogah_names' 
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $NIR= new Ansaldo_nirogah_name();
        $NIR->NIROGAH_NAME=$request->input('NIROGAH_NAME');
        $NIR->ID_USER=$id_user;
        $NIR->save();
        $id_nn = DB::table('ansaldo_nirogah_names')->where('ID_USER',$id_user)->orderBy('ID_NN', 'DESC')->first()->ID_NN;
        return response()->json(['success'=>'hi','id_nn'=>$id_nn]);
    }
    /**
     * In this method we get the total rows from ansaldo_out_ghataats table. this table is used to store the cases that we send outside of company 
     * for reconstruction. 
     * in addition to this information we get the ids of the type of equipment .
     * after that we send these two data to our view.
     */ 
    public function total()
    {
        $data = DB::table('ansaldo_nirogah_names')->where('ID_NN','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    /**
     * In this method we remove a row from ansaldo_buy_ghataats.but we should note that the id 
     * which we want to remove from this table should not be used in ansaldo_savabeghs table as forign key.
     * then we send the id to our view and set perm(permission) one for removing.
     * otherwise we  set perm(permission) zero to the view to show appropriate alert to the user.
     */  
    public function delete($id){
        $id_user=auth()->user()->id;
        $id_nn = DB::table('ansaldo_nirogah_names')->where('ID_USER',$id_user)->orderBy('ID_NN', 'DESC')->first()->ID_NN;
        Ansaldo_nirogah_name::where('ID_NN', $id)->delete();
        return response()->json(['success'=>'hi','id_nn'=>$id_nn]);
    }
    /**
     * In this method we are going to edit the fields of ansaldo_buy_ghataats table with specific id
     */
    public function edit(Request $request)
    {
        $id_nn=$request->input('ID_NN_EDIT');
        $NIROGAH_NAME=$request->input('NIROGAH_NAME_EDIT');
        Ansaldo_nirogah_name::where('ID_NN', $id_nn)->update(['NIROGAH_NAME'=>$NIROGAH_NAME]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
