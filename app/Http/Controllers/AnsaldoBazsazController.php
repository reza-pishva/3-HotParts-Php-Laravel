<?php
namespace App\Http\Controllers;

use App\Ansaldo_bazsaz;
use App\Ansaldo_nirogah_name;
use App\User;
use App\CalendarHelper;
use Carbon\Carbon;
use App\Exit_goods_permission;
use App\Form;
use App\Goodstype;
use App\Grouprole;
use App\Groupuser;
use App\Request_level;
use App\Role;
use App\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AnsaldoBazsazController extends Controller
{
    /**
     * In this method we store the name of company that we want to send our equipment for reconstruction.
     * in first line we get the id of user who wants to store the name of company.
     * We create an instance from the model of company name table.
     * then we get the name of company from its form and fill the property of our instance.
     * we fill the id_user property of our instance.
     * then we save them into 'ansaldo_bazsazs' and we get the id of this record and send it to the view of this form to be able to
     * change the color of this new record in the table
     */
    public  function bazsaz_store(Request $request){
        $id_user=auth()->user()->id;
        $bazsaz= new Ansaldo_bazsaz();
        $bazsaz->BAZSAZ=$request->input('BAZSAZ');
        $bazsaz->ID_USER=$id_user;
        $bazsaz->save();
        $id_ba = DB::table('ansaldo_bazsazs')->where('ID_USER',$id_user)->orderBy('ID_BA', 'DESC')->first()->ID_BA;
        return response()->json(['success'=>'true','id_ba'=>$id_ba]);
    }
    
    
    
   /**
     * In this method we authorize the person who wants to open the form which we can initialize base information in this software
     * such as power  plant name,company name, maintenance types and ...
     * first we get the id , first name and last name of current user.then we retrieve the groups that our user belongs to.
     * then we get the roles of this user from different groups which this user belongs to after first foreach.
     * in the second foreach we get the name of roles of this user that has and if it was admin or track_base_tables 
     * we return the view of ansaldo_base_tables and at the same time we pass the name of companies and power plant names to this view
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
                        if($role_name['role'] ==="admin" or $role_name['role'] ==="track_base_tables"){
                           $allow=1;
                           $requests=Ansaldo_bazsaz::all();
                           $pps=Ansaldo_nirogah_name::all();
                           return view('Ansaldo.ansaldo_base_tables',compact('requests','pps'));
                        }
               }
       }
       if($allow===0){
         return view('access_denied');
       }
    }
    
    
    
    
    
    public function bazsaz_total()
    {
        $data = DB::table('ansaldo_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function delete($id){
        $n= DB::table('ansaldo_send_bazsazi_ghataats')->where('ID_BA',$id)->get()->count();
        if($n==0){
            Ansaldo_bazsaz::where('ID_BA', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
    public function bazsaz_edit(Request $request)
    {
        $id_ba=$request->input('ID_BA_EDIT');
        $bazsaz=$request->input('BAZSAZ_EDIT');
        Ansaldo_bazsaz::where('ID_BA', $id_ba)->update(['BAZSAZ'=>$bazsaz]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
